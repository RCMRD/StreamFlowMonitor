<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Facades\Validator;
use App\Setting;
use App\User;
use App\Currency;
use App\Role;
use Illuminate\Support\Facades\File;

class SystemController extends Controller { 



    function index()
    {  

       if(env('ENABLE_APP_SETUP_CONFIG') == TRUE)
       {
          return redirect()->route('dashboard');
       }     

        $data['sym_link_eanabled'] = FALSE;

        try{            

            // Delete if it already exists
            File::deleteDirectory(public_path().'/storage');
            File::deleteDirectory(public_path().'/install');

            // Create symlink
            \Artisan::call("storage:link");
            
            if(is_dir(public_path().'/storage'))
            {
                $data['sym_link_eanabled'] = TRUE;
            }            

        }
        catch(\Exception $e)
       {        
            $data['sym_link_eanabled'] = FALSE;
       }

        
        return view('installer.requirements', compact('data'))->with('rec', "");

        
    }

    function general_information(Request $request)
    {

        $rec = (object) $request->session()->get('general');

        return view('installer.general')->with('data', "")->with('rec', $rec );
    }


    function store_general_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name'  => 'required',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email',
            'job_title'     => 'required',
            'password'      => 'required|min:6',
            'currency_iso_code' => 'required|min:3|max:3',
            'currency_symbol' => 'required|max:3'

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->session()->put('general', $request->all());
        
       
        return redirect()->route('run_installation_step_3_page');
    }


    function database_information()
    {
        return view('installer.db')->with('data', "")->with('rec', "");
    }


    function run_page()
    {
        return view('installer.run');
    }


    function setup_database(Request $request)
    {
      
        ini_set('max_execution_time', 0); //300 seconds = 5 minutes
        ini_set('memory_limit', '-1');
		
		

        DB::beginTransaction();
        $success = false;

        $general_information = (object) $request->session()->get('general');
       

        try {
            
            \Artisan::call('migrate');
            \Artisan::call('db:seed');

            // Update Company name in Settings table
            $setting                = Setting::updateOrCreate(['option_key' => 'company_name' ]);
            $setting->option_value  = trim($general_information->company_name);
            $setting->save();

            // Insert Currency            
            $currency                    = new Currency();
            $currency->code              = trim($general_information->currency_iso_code);
            $currency->symbol            = trim($general_information->currency_symbol);     
            $currency->is_default        = TRUE;          
            $currency->save();

            $shortcode = gen_team_member_short_code($general_information->first_name . " ". $general_information->last_name);
            
            // Create User
            $user                    = new User();
            $user->short_code        = $shortcode;
            $user->first_name        = $general_information->first_name;
            $user->last_name         = $general_information->last_name;
            $user->email             = $general_information->email;
            $user->password          = Hash::make($general_information->password) ;            
            $user->job_title         = $general_information->job_title;            
            //$user->is_administrator  = TRUE;
            $user->save();
			
			$role=Role::find(1);
			$user->attachRole($role);

            $this->finalize_env_setup();

            $data['status']     = 1;
            $data['title']      =  'Successfully Installed';
            $data['icon']       = 'fa-check-circle';
            $data['msg']        = "Your application has been successfully installed. <br> <br> Please click the button below to login to your application <br>";
             DB::commit();
            $success = true;

        }        
        catch (\Exception $e) {
            
            $filename = 'installation_error_log.txt';
            $url = route('download_error_log', $filename);

            $data['status']     = 2;
            $data['title']      =  'Installation Failed!';
            $data['icon']       = 'fa-exclamation-triangle';
            $data['msg']        = "A problem occured during installation and was interrupted. You can download the error log here 
            <a target='_blank' href='".$url."'>Error Log<a>";

            DB::rollback();
            $success = false;
            $this->initial_env_setup();

            
            $log_message = $e->getMessage(). " \n \n Line: ". $e->getLine(). " ". $e->getFile() ;
            \Storage::put($filename, $log_message );          
          
        }

       

        $request->session()->flash('instllation_status', $data);
        return response()->json(['status' => $success]);
        
    }

    public function download($path)
     {
         return Storage::download($path);
     }


    function installation_result()
    {
        $data = session('instllation_status');

        if(!empty($data))
        {
            return view('installer.result', compact('data'));
        }
        else
        {
            return redirect()->route('installer_page');
        }
        
    }


    function installation_failed()
    {
        $data['status']     = 2;
        $data['title']      =  'Installation Failed!';
        $data['icon']       = 'fa-exclamation-triangle';
        $data['msg']        = "A problem occured during installation and was interrupted";
        return view('installer.result', compact('data'));
    }
    
   

    function setup_database_connection(Request $request)
    {        

        $validator = Validator::make($request->all(), [
            'site_base_url'         => 'required',
            'db_host'               => 'required',
            'db_name'               => 'required',
            'db_user_name'          => 'required',
            
        ]);

        if ($validator->fails()) 
        {

             return  redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $app_url            = $request->input('site_base_url');
        $host               = $request->input('db_host');
        $username           = $request->input('db_user_name');
        $password           = $request->input('db_user_password');
        $dbname             = $request->input('db_name');
       

        

        // Check if database connection is alright
        if($conn = $this->check_db_connection($host, $dbname, $username, $password))
        {
            if($this->set_env($host, $dbname, $username, $password, $app_url))
            {
                $data = [];
                
                return view('installer.db_connect_success', compact('data'));
            }
            else
            {
                $request->session()->flash('error_msg', 'There was a problem saving your database information and installation was interrupted');
                return redirect()->back();
        
            }



        }
        else
        {
            $request->session()->flash('error_msg', 'Invalid Database Credential Provided');
            return redirect()->back();
        }
    }

    

    

    private function set_env($host, $dbname, $username, $password, $app_url)
    {
        // If database connection is alright, update the ENV file.
        DotenvEditor::setKeys([
            [
                'key'     => 'APP_ENV',
                'value'   => 'development',

            ],
            [
                'key'     => 'APP_DEBUG',
                'value'   => 'TRUE',

            ],
            [
                'key'     => 'ENABLE_APP_SETUP_CONFIG',
                'value'   => 'FALSE',

            ],
            [
                'key'     => 'APP_URL',
                'value'   => $app_url,

            ],
            [
                'key'     => 'DB_HOST',
                'value'   => $host,

            ],
            [
                'key'     => 'DB_DATABASE',
                'value'   => $dbname,

            ],
            [
                'key'     => 'DB_USERNAME',
                'value'   => $username,

            ],
            [
                'key'     => 'DB_PASSWORD',
                'value'   => $password,

            ],


        ]);

        DotenvEditor::save();

        return TRUE;
    }

    private function initial_env_setup()
    {
        // If database connection is alright, update the ENV file.
        DotenvEditor::setKeys([
            [
                'key'     => 'ENABLE_APP_SETUP_CONFIG',
                'value'   => '',

            ],
            
            [
                'key'     => 'APP_DEBUG',
                'value'   => 'TRUE',

            ],
            [
                'key'     => 'ENABLE_APP_SETUP_CONFIG',
                'value'   => 'FALSE',

            ],
            
        ]);

        DotenvEditor::save();

        return TRUE;
    }

    private function finalize_env_setup()
    {
        // If database connection is alright, update the ENV file.
        DotenvEditor::setKeys([
            [
                'key'     => 'APP_ENV',
                'value'   => 'production',

            ],
            [
                'key'     => 'APP_DEBUG',
                'value'   => 'FALSE',

            ],
            [
                'key'     => 'ENABLE_APP_SETUP_CONFIG',
                'value'   => 'TRUE',

            ],
			[
                'key'     => 'APP_URL',
                'value'   => 'RCMRDProjectsManagementSystem',

            ],
            
        ]);

        DotenvEditor::save();

        return TRUE;
    }



    private function check_db_connection($servername, $dbname, $username, $password)
    {
        try {

            $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return TRUE;

        }
        catch(\PDOException $e)
        {
            return FALSE;
        }
    }


}