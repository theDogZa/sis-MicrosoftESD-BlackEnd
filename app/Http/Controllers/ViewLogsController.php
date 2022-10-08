<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ViewLogsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {

        $this->middleware('RolePermission');
        // $this->middleware(function ($request, $next) {
        //     $this->addlog_sys($request);
        //     return $next($request);
        // });

        Cache::flush();
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: text/html');
        $this->arrShowFieldSysLogs = [
            'app' => 1, 'username' => 1, 'ip' => 1, 'date' => 1,  'uri' => 1, 'action' => 1, 'methods' => 1, 'response_code' => 1, 'detial' => 1
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sysLogs(Request $request)
    {
        $dir = "/log_sys/";
        
        $compact = (object) array();

        $date = $request['date'];

        if(!$date) $date = date('Y-m-d');

        $fileName = "syslog-". $date.".log";

        $file = storage_path() . $dir. $fileName;

        $content = File::get($file);

        foreach (explode("\n", $content) as $key => $line) {

            if (strpos($line, "#")) {
                $isShow = true;
                $newData = [];
                list($time, $name, $data) = explode("#", $line);

                $newData = json_decode($data);

                if (!$request->user()->hasRole('developer')) {
                    if($newData->username == 'dev'){
                        $isShow = false;
                    }
                }

                if($isShow == true){
                    $paraUri = explode("/", $newData->uri);
                    if($paraUri[0] != 'api'){
                        if(count($paraUri)>1){
                            if(count((array)$newData->parameters)>0){
                                $arrPara = (array)$newData->parameters;
                                foreach($paraUri as $key => $paRa){
                                    if($key > 0){
                                        $nParaUrl = str_replace(['{', '}'], '', $paRa);
                                        
                                        if(@isset($arrPara[$nParaUrl])){
                                            $newData->url = $paraUri[0]. '/'.$arrPara[$nParaUrl];
                                        }
                                    }
                                }
                            }
                        }else{
                            $newData->url = $newData->uri;
                        }
                    }else{
                        $newData->url = $newData->uri;
                    }

                    $arrayLog[] = $newData;
                }
                
            }
        }
        krsort($arrayLog);

        $compact->arrShowField = $this->arrShowFieldSysLogs;

        $compact->collection = $arrayLog;

        $compact->total = count($arrayLog);
        $compact->arrApp = array('FrontEnd' => 'FrontEnd', 'BackEnd' => 'Backend');

        if (is_dir(storage_path().$dir)) {

            if ($dh = opendir(storage_path().$dir)) {
                $arrDate = [];
                while (($file = readdir($dh)) !== false) {
                    
                    if($file != '.' &&  $file != '..'&&  $file != ''){
                        $aFn = explode("syslog-", $file);
                        $arrDate[] = explode(".log", $aFn[1])[0];
                    }         
                }
                krsort($arrDate);           
                closedir($dh);
            }
            $compact->selectDate = $arrDate;
            $compact->sDate = $date;

        }
        
        return view('_view_logss.syslogs', (array) $compact);
    }

    public function sysLogsUser(Request $request)
    {
        $dir = "/log_sys/";

        $compact = (object) array();
        $arrSearch = [];
        $arrayLog = [];
        $date = '';

        if (count($request->all())) {
            $input = (object) $request->all();
            if (@$input->search) {
                $date = $request['search'];
            } else {
                $arrSearch = $input;
                $date = $input->date;
            }
        }
        
        if (!$date) $date = date('Y-m-d');

        $fileName = "syslog-" . $date . ".log";

        $file = storage_path() . $dir . $fileName;

        $content = File::get($file);

        foreach (explode("\n", $content) as $key => $line) {

            if (strpos($line, "#")) {
                $isShow = true;
                $newData = [];
                list($time, $name, $data) = explode("#", $line);

                $newData = json_decode($data);

                if(!empty($arrSearch)){
                    if ($this->_advSearch($newData, $arrSearch)) {
                        $isShow = true;
                    }else{
                        $isShow = false;
                        
                    }
                    //dd($this->_advSearch($newData, $arrSearch), $isShow);
                }else{
                    $isShow == true;
                }             

                if (!$request->user()->hasRole('developer')) {
                    if (@$newData->username == 'dev') {
                        $isShow = false;
                    }
                }

                if ($isShow == true) {
                    if(@$newData->methods[0] == 'GET'){
                        $paraUri = explode("/", $newData->uri);

                        if ($paraUri[0] != 'api') {
                            if (count($paraUri) > 1) {
                                if (count((array)$newData->parameters) > 0) {
                                    $arrPara = (array)$newData->parameters;
                                    foreach ($paraUri as $key => $paRa) {
                                        if ($key > 0) {
                                            $nParaUrl = str_replace(['{', '}'], '', $paRa);                                        
                                            if (@isset($arrPara[$nParaUrl])) {
                                                $newData->url = str_replace($paRa, $arrPara[$nParaUrl], $newData->uri);
                                            }
                                        }
                                    }
                                }else{
                                    $newData->url = $newData->uri;
                                }
                            } else {
                                $newData->url = $newData->uri;
                            }
                        } else {
                            $newData->url = $newData->uri;    
                        }
                    }else{
                        if(@$newData->uri == 'login'){
                            $newData->url = $newData->uri;
                        }else{
                            if (@$newData->action == 'api.orgcode') {
                                $newData->url = "";
                                $arrPara = (array)$newData->parameters;
                                $arrReq['orgcode'] = $arrPara['id'];
                                $newData->request = (object) $arrReq;

                            } else {
                                $paraUri = explode("/", @$newData->uri);
                                if ($paraUri[0] != 'api') {
                                    @$newData->url = "";
                                }else{
                                    @$newData = [];
                                }
                            }                       
                        }                  
                    }
                    if(!empty($newData)){

                        $arrayLog[] = $newData; 
                    }
                }
            }
        }
        if(!empty($arrayLog)){
            krsort($arrayLog);
        }
      //  dd( $arrayLog ,$isShow);
        $compact->arrShowField = $this->arrShowFieldSysLogs;

        $compact->collection = $arrayLog;

        $compact->total = count($arrayLog);

        $compact->search = (object) $request->all();

        if (is_dir(storage_path() . $dir)) {

            if ($dh = opendir(storage_path() . $dir)) {
                $arrDate = [];
                $strDate = "";
                while (($file = readdir($dh)) !== false) {

                    if ($file != '.' &&  $file != '..' &&  $file != '') {
                        $aFn = explode("syslog-", $file);
                        $arrDate[] = explode(".log", $aFn[1])[0];
                        $strDate = $strDate.'"'. explode(".log", $aFn[1])[0] . '",';
                    }
                }
                krsort($arrDate);
                closedir($dh);
            }
            $compact->selectDate = $arrDate;
            $compact->sDate = $date;
            $compact->strDate = substr_replace($strDate, "", -1);

            $arrMapAction = [];
            $arrMapAction['index'] = trans('view_logs.action.index');
            $arrMapAction['edit'] = trans('view_logs.action.edit');
            $arrMapAction['update'] = trans('view_logs.action.update');
            $arrMapAction['update_permissions_roles'] = trans('view_logs.action.update_permissions_roles');
            $arrMapAction['list_permissions'] = trans('view_logs.action.list_permissions');
            $arrMapAction['update_user_roles'] = trans('view_logs.action.update_user_roles');
            $arrMapAction['show'] = trans('view_logs.action.show');
            $arrMapAction['create'] = trans('view_logs.action.create');
            $arrMapAction['del'] = trans('view_logs.action.del');
            $arrMapAction['show'] = trans('view_logs.action.show');
            $arrMapAction['store'] = trans('view_logs.action.store');
            $arrMapAction['storeRoles'] = trans('view_logs.action.storeRoles');
            $arrMapAction['destroy'] = trans('view_logs.action.destroy');
            $arrMapAction['orgcode'] = trans('view_logs.action.orgcode');
            $arrMapAction['call'] = trans('view_logs.action.call');
            
            $arrMapMenu = [];
            $arrMapMenu['rolesPermission'] = 'Roles';
            $arrMapMenu['userRoles'] = 'Roles';
            $arrMapMenu['log_api'] = 'Log Tenants';
            $arrMapMenu['api'] = 'Open Tenants';
            $arrMapMenu['openTenants'] = 'Open Tenants';
            $arrMapMenu['users_permissions'] = 'users permissions';

            $compact->mapAction = $arrMapAction;
            $compact->mapMenu = $arrMapMenu;
        }
        return view('_view_logs.syslogs_user', (array) $compact);
    }

    public function sysLogsUser2(Request $request)
    {
        $dir = "/log_sys/";

        $compact = (object) array();
        $arrSearch = [];
        $arrayLog = [];
        $date = '';

        if (count($request->all())) {
            $input = (object) $request->all();
            if (@$input->search) {
                $date = $request['search'];
            } else {
                $arrSearch = $input;
                $date = $input->date;
            }
        }

        if (!$date) $date = date('Y-m-d');

        $fileName = "syslog-" . $date . ".log";

        $file = storage_path() . $dir . $fileName;

        $content = File::get($file);

        foreach (explode("\n", $content) as $key => $line) {
            
            if (strpos($line, "#")) {
                $isShow = true;
                $newData = [];

                list($time, $name, $data) = explode("#", $line);

                $newData = (object)json_decode($data);

                $newData->app = $name;

                if (!empty($arrSearch)) {
                    if ($this->_advSearch($newData, $arrSearch)) {
                        $isShow = true;
                    } else {
                        $isShow = false;
                    }
                } else {
                    $isShow == true;
                }

                if (!$request->user()->hasRole('developer')) {
                    if (@$newData->username == 'dev') {
                        $isShow = false;
                    }
                }

                if (@$newData->view != 'A' ) {
                    $isShow = false;
                }
               //dd($time, $name, $data, $newData->view, $isShow);

                if ($isShow == true) {
                    if (@$newData->methods[0] == 'GET') {
                        $paraUri = explode("/", $newData->uri);

                        if ($paraUri[0] != 'api') {
                            if (count($paraUri) > 1) {
                                if (count((array)$newData->parameters) > 0) {
                                    $arrPara = (array)$newData->parameters;
                                    foreach ($paraUri as $key => $paRa) {
                                        if ($key > 0) {
                                            $nParaUrl = str_replace(['{', '}'], '', $paRa);
                                            if (@isset($arrPara[$nParaUrl])) {
                                                $newData->url = str_replace($paRa, $arrPara[$nParaUrl], $newData->uri);
                                            }
                                        }
                                    }
                                } else {
                                    $newData->url = $newData->uri;
                                }
                            } else {
                                $newData->url = $newData->uri;
                            }
                        } else {
                            $newData->url = $newData->uri;
                        }
                    } else {
                        if (@$newData->uri == 'login') {
                            $newData->url = $newData->uri;
                        } else {
                            @$newData->url = "";
                        }
                    }
                    if ($request->user()->hasRole('developer')) {
                        if(@$newData->response){
                            $res = @$newData->response;

                            if (is_array($res) || is_object($res)){
                                foreach ($res as $k => $v){
                                    if(@$k != '_token' && @$k !='_method' && @$k !='slug'){

                                        if (is_array($v) || is_object($v)){

                                            foreach ($v as $ck => $cv) {
                                                if (is_array($cv) || is_object($cv)) {

                                                    foreach ($cv as $cck => $ccv) {

                                                        $newRes[$cck] = $ccv;
                                                    }
                                                }else{
                                                    $newRes[$ck] = $cv;
                                                }
                                            }

                                        }else{

                                            $newRes[$k] = $v;
                                        }
                                    }
                                }
                            }else{
                                $newRes = $res; 
                            }
                            $newData->response = $newRes;
                        }

                    }else{
                        $newData->response = true;
                    }

                    if (!empty($newData)) {
                        $arrayLog[] = $newData;
                    }
                }
            }
        }
        if (!empty($arrayLog)) {
            krsort($arrayLog);
        }
        //dd( $arrayLog ,$isShow);

        $compact->arrShowField = $this->arrShowFieldSysLogs;

        $compact->collection = $arrayLog;

        $compact->total = count($arrayLog);

        $compact->search = (object) $request->all();

        if (is_dir(storage_path() . $dir)) {

            if ($dh = opendir(storage_path() . $dir)) {
                $arrDate = [];
                $strDate = "";
                while (($file = readdir($dh)) !== false) {

                    if ($file != '.' &&  $file != '..' &&  $file != '') {
                        $aFn = explode("syslog-", $file);
                        $arrDate[] = explode(".log", $aFn[1])[0];
                        $strDate = $strDate . '"' . explode(".log", $aFn[1])[0] . '",';
                    }
                }
                krsort($arrDate);
                closedir($dh);
            }
            $compact->selectDate = $arrDate;
            $compact->sDate = $date;
            $compact->strDate = substr_replace($strDate, "", -1);

            $arrMapAction = [];
            $arrMapAction['index'] = trans('view_logs.action.index');
            $arrMapAction['edit'] = trans('view_logs.action.edit');
            $arrMapAction['update'] = trans('view_logs.action.update');
            $arrMapAction['update_permissions_roles'] = trans('view_logs.action.update_permissions_roles');
            $arrMapAction['list_permissions'] = trans('view_logs.action.list_permissions');
            $arrMapAction['update_user_roles'] = trans('view_logs.action.update_user_roles');
            $arrMapAction['show'] = trans('view_logs.action.show');
            $arrMapAction['create'] = trans('view_logs.action.create');
            $arrMapAction['del'] = trans('view_logs.action.del');
            $arrMapAction['show'] = trans('view_logs.action.show');
            $arrMapAction['store'] = trans('view_logs.action.store');
            $arrMapAction['storeRoles'] = trans('view_logs.action.storeRoles');
            $arrMapAction['destroy'] = trans('view_logs.action.destroy');
            $arrMapAction['orgcode'] = trans('view_logs.action.orgcode');
            $arrMapAction['call'] = trans('view_logs.action.call');

            $arrMapMenu = [];
            $arrMapMenu['rolesPermission'] = 'Roles';
            $arrMapMenu['userRoles'] = 'Roles';
            $arrMapMenu['log_api'] = 'Log Tenants';
            $arrMapMenu['api'] = 'Open Tenants';
            $arrMapMenu['openTenants'] = 'Open Tenants';
            $arrMapMenu['users_permissions'] = 'users permissions';

            $compact->mapAction = $arrMapAction;
            $compact->mapMenu = $arrMapMenu;
            $compact->arrApp = array('FrontEnd' => 'FrontEnd', 'BackEnd' => 'Backend');
        }
        return view('_view_logs.syslogs_user', (array) $compact);
    }

    /**
     * If the user has entered an IP address and a username, the function will check if the IP address
     * and username are contained in the results
     * 
     * @param results The results of the query
     * @param input the input object
     * 
     * @return The results of the search.
     */
    protected function _advSearch($results, $input){
        
        $chk = true;
        
        if(@$input->ip && @$input->username){
            if(!str_contains(@$results->ip, @$input->ip) || !str_contains(@$results->username, @$input->username)){
                $chk = false;
            }
        }elseif(@$input->ip && !@$input->username) {
            if (!str_contains(@$results->ip, @$input->ip)) {
                $chk = false;
            }

        }elseif(!@$input->ip && @$input->username) {
            if (!str_contains(strtolower(@$results->username), strtolower(@$input->username))) {
                $chk = false;
            }

        } elseif (@$input->app) {
            if ($input->app != $results->app ) {
                $chk = false;
            }
        }

        return $chk;
    }

    

}
