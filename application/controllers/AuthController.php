<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/28/17
 * Time: 10:34 PM
 */
class AuthController extends CI_Controller
{
    public function index()
    {
        redirect(base_url().'auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url().'auth/login');
    }

    public function login()
    {
        if($this->session->userdata('logged_in')){
            redirect(base_url().'dash/home');
        }
        else
        {
            $this->load->library('form_validation');
            $data = array();
            $data['error'] = false;
            $this->form_validation->set_rules('username', 'Username' , 'required');
            $this->form_validation->set_rules('password', 'Password' , 'required');
            if($this->form_validation->run() == TRUE) {
                $user_auth = $this->input->post('username');
                $user_password = $this->input->post('password');
                $user_password = md5($user_password);
                $adminResult = $this->User_model->FindUserByArray(array('NAME' => $user_auth, 'LEVEL' => '4'));
                if(count($adminResult) > 0)
                {
                    if($adminResult[0]['PASSWORD'] == $user_password && ($adminResult[0]['BLOCK_TIME'] == 0 || round(abs($adminResult[0]['BLOCK_TIME'] - time()) / 60,2) > 10))
                    {
                        $this->User_model->UpdateUserObject(array('LOGIN_ATTEMPT' => '0', 'BLOCK_TIME' => '0'), array('ID' => $adminResult[0]['ID']));
                        $session_value = array('logged_in' => true, 'me' => $adminResult[0]);
                        $this->session->set_userdata($session_value);
                        //update login history table
                        $this->LoginHistory_model->InsertNewHistory(array(  'USER_ID' => $adminResult[0]['ID'],
                                                                            'FROM_IP' => $this->input->ip_address(),
                                                                            'SUCCESS' => '1',
                                                                            'UPDATED_AT' => time(),
                                                                            'CREATED_AT' => time()));
                        redirect(base_url().'dash/home');
                    }
                    else
                    {
                        // password is inmatched
                        if($adminResult[0]['LOGIN_ATTEMPT'] < 3)
                        {
                            $this->User_model->UpdateUserLoginAttempt($adminResult[0]['ID']);
                            if ($adminResult[0]['LOGIN_ATTEMPT'] + 1 == 3) {
                                $this->User_model->UpdateUserObject(array('BLOCK_TIME' => time()), array('ID' => $adminResult[0]['ID']));
                                //send email notification
                                if($adminResult[0]['NOTIFY_LOGIN_FAILS'] == 1)
                                    $this->SendLoginFailMessage($adminResult[0]['EMAIL'], $adminResult[0]['FULL_NAME'], $this->input->ip_address());
                            }
                        }
                        $data['error'] = true;
                    }
                }
                else{
                    // id is not exists
                    $data['error'] = true;
                }
            }
            $this->load->view('client/auth/login', $data);
        }
    }

    public function forgotpassword()
    {
        $this->load->view('client/auth/forgotpassword');
    }

    public function register()
    {
        if($this->session->userdata('logged_in')){
            redirect(base_url().'dash/home');
        }
        else
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('firstname', 'First Name' , 'trim|required');
            $this->form_validation->set_rules('lastname', 'Last Name' , 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('username', 'User Name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('rpassword', 'Confirm Password', 'required|matches[password]');
            $data = array();
            $data['emailExist'] = false;
            $data['nameExist'] = false;
            if($this->form_validation->run() == TRUE) {
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $email = $this->input->post('email');
                $address = $this->input->post('address');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $rpassword = $this->input->post('rpassword');
                $existEmail = $this->User_model->FindUserByArray(array('EMAIL' => $email, 'LEVEL' => '4'));
                $existName = $this->User_model->FindUserByArray(array('NAME' => $username, 'LEVEL' => '4'));
                if(count($existEmail) > 0) {
                    $data['emailExist'] = true;
                }
                else if(count($existName) > 0) {
                    $data['nameExist'] = true;
                }
                else {

                }
            }
        }
        $this->load->view('client/auth/register', $data);
    }


    private function SendLoginFailMessage($targetEmail, $userName, $ipAddress)
    {
        $this->email->initialize($this->config->item('EMAIL'));
        $this->email->from('admin@bookmapp.com','admin@bookmapp.com');
        $this->email->to($targetEmail);
        $this->email->subject('Valor Pay Support team');
        $content = "Hi, <strong>".$userName."</strong><br>LogIn is failed from ".$ipAddress.". Is this you?";
        $this->email->message($content);
        $result = $this->email->send();
        echo($result);
    }
}