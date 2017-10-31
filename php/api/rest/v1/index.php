<?php
ini_set('display_errors',1); 
require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '../lib/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();
 
// User id from db - Global Variable
$user_id = NULL;
 
/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        print_r($app->request()->getBody());
        parse_str($app->request()->getBody(), $request_params);
    }
    
    print_r($request_params);
    
    foreach ($required_fields as $field) {
        echo $field."<br>";
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}

$app->post('/register', function() use ($app) {
            // check for required params

	verifyRequiredParams(array('name', 'email', 'password'));
 
            $response = array();
 
            // reading post params
            $name = $app->request->post('name');
            $email = $app->request->post('email');
            $password = $app->request->post('password');
 
            // validating email address
            validateEmail($email);
 
            $db = new DbHandler();
            $res = $db->createUser($name, $email, $password);
 
            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
                echoRespnse(201, $response);
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";
                echoRespnse(200, $response);
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this email already existed";
                echoRespnse(200, $response);
            }
        });

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('email', 'password'));
 
            // reading post params
            $email = $app->request()->post('email');
            $password = $app->request()->post('password');
            $response = array();
 
            $db = new DbHandler();
            // check for correct email and password
            if ($db->checkLogin($email, $password)) {
                // get the user by email
                $user = $db->getUserByEmail($email);
 
                if ($user != NULL) {
                    $response["error"] = false;
                    $response['name'] = $user['name'];
                    $response['email'] = $user['email'];
                    $response['apiKey'] = $user['api_key'];
                    $response['createdAt'] = $user['created_at'];
                } else {
                    // unknown error occurred
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                // user credentials are wrong
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect credentials';
            }
 
            echoRespnse(200, $response);
        });
 
/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();
 
        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user = $db->getUserId($api_key);
            if ($user != NULL)
                $user_id = $user["id"];
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Creating new faq in db
 * method POST
 * params - name
 * url - /faqs/
 */
$app->post('/faqs', 'authenticate', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('question','answer'));
 
            $response = array();
	    $faq = array(); 
            $faq['question'] = $app->request->post('question');
	    $faq['answer'] = $app->request->post('answer');
 
            global $user_id;
            $db = new DbHandler();
 
            // creating new task
            $faq_id = $db->createFaq($user_id, $faq);
 
            if ($faq_id != NULL) {
                $response["error"] = false;
                $response["message"] = "Faq created successfully";
                $response["faq_id"] = $faq_id;
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to create task. Please try again";
            }
            echoRespnse(201, $response);
        });


/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/faqs', 'authenticate', function() {
            global $user_id;
            $response = array();
            $db = new DbHandler();
 
            // fetching all user tasks
            $result = $db->getFaqs();
 
            $response["error"] = false;
            $response["faqs"] = array();
 
            // looping through result and preparing tasks array
            while ($faq = $result->fetch_assoc()) {
                $tmp = array();
                $tmo["id"] = $faq["id"];
                $tmp["question"] = $faq["question"];
                $tmp["answer"] = $faq["answer"];
                $tmp["status"] = $faq["status"];
                array_push($response["faqs"], $tmp);
            }
 
            echoRespnse(200, $response);
        });

$app->get('/faqs/:id', 'authenticate', function($faq_id) {
            global $user_id;
            $response = array();
            $db = new DbHandler();

            // fetch task
            $result = $db->getFaqs($faq_id);
	    $result = $result->fetch_assoc();

            if ($result != NULL) {
                $response["error"] = false;
                $response["id"] = $result["id"];
                $response["question"] = $result["question"];
                $response["answer"] = $result["answer"];
                $response["status"] = $result["status"];
                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });

    $app->put('/faqs/:id', 'authenticate', function($faq_id) use($app) {
            // check for required params
            //verifyRequiredParams(array('question','answer', 'status'));
 
            global $user_id;            
            $question = $app->request->put('question');
            $answer = $app->request->put('answer');
            $status = $app->request->put('status');
 
 	    $faq = array('id'=>$faq_id,'question' => $question,'answer'=>$answer,'status'=>$status);
            $db = new DbHandler();
            $response = array();
 
            // updating task
            $result = $db->updateFaq($faq);
            if ($result) {
                // task updated successfully
                $response["error"] = false;
                $response["message"] = "Task updated successfully";
            } else {
                // task failed to update
                $response["error"] = true;
                $response["message"] = "Task failed to update. Please try again!";
            }
            echoRespnse(200, $response);
        });
    
    $app->delete('/faqs/:id', 'authenticate', function($faq_id) use($app) {
            global $user_id;
 
            $db = new DbHandler();
            $response = array();
            $result = $db->deleteFaq($faq_id);
            if ($result) {
                // task deleted successfully
                $response["error"] = false;
                $response["message"] = "Task deleted succesfully";
            } else {
                // task failed to delete
                $response["error"] = true;
                $response["message"] = "Task failed to delete. Please try again!";
            }
            echoRespnse(200, $response);
        });

$app->run();
?>
