<?php


namespace App\Helpers;

use App\Models\LogActivity as ModelsLogActivity;
use Illuminate\Support\Facades\Request;

class LogActivity
{

    /**
     * Allows you to save the logs of the api processes
     *
     * @param string $subject
     * @param bool $success
     * @param string $endpoint
     * @param string $requestValues
     * @param string $message
     *
     * @return boolean
     *
     * Created at: 2/4/2023, 11:12:19 AM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public static function addToLog($subject,$success = true,$endpoint = "",$requestValues = "",$message = "")
    {
    	$log = [];
    	$log['subject'] = $subject;
        $log['success'] = $success;
        $log['endpoint'] = $endpoint;
    	$log['method'] = Request::method();
        $log['url'] = Request::fullUrl();
    	$log['ip'] = Request::ip();
        $log['values'] = $requestValues;
        $log['message'] = $message;
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;

        try {

            ModelsLogActivity::create($log);

        } catch (\Throwable $exception) {

        }

    }

    /**
     * List all the API logs in descending order
     *
     * @return [type]
     *
     * Created at: 2/4/2023, 11:14:35 AM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public static function logActivityLists()
    {
    	return ModelsLogActivity::latest()->get();
    }

}
