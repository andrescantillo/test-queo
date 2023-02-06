<?php

namespace App\Traits;

trait ApiResponse{

    /**
     * Function allows the json type API response with a defined structure when the request response is successful
     *
     * @param string $data
     * @param null $message
     * @param int $code
     *
     * @return json
     *
     * Created at: 2/4/2023, 11:11:20 AM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    protected function successResponse($data, $message = null, $code = 200)
	{
		return response([
			'status'=> 'Success',
			'message' => $message,
			'data' => $data,
            'errors' => null,
            'code' => $code
		])->setStatusCode($code);
	}

	/**
	 * Function allows the response of the API type json with a defined structure when the response of the request is not successful
	 *
	 * @param string $errorMessages
	 * @param array $errors
	 * @param int $code
	 * @param array $trace
	 *
	 * @return json
	 *
	 * Created at: 2/4/2023, 11:11:23 AM (America/Bogota)
	 * @author     Andres Cantillo Nava
	 */
	protected function errorResponse($errorMessages, $errors = [], $code = 404, $trace = [])
	{
		return response()->json([
			'status'=>'Error',
			'message' => $errorMessages,
			'data' => null,
            'errors' => $errors,
            'code' => $code,
            'trace' => $trace
		], $code);
	}

}
