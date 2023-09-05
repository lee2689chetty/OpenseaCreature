<?php

/**
 * Created by PhpStorm.
 * User: rock
 * Date: 12/28/17
 * Time: 10:34 PM
 */
class AdminAuthController extends CI_Controller
{
    public function index()
    {
        redirect(base_url().'admin/auth/login');
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('me');
        redirect(base_url().'admin/auth/login');
    }

    public function login()
    {
        if($this->session->userdata('logged_in') && intval($this->session->userdata('me')['LEVEL']) < 4 ){
            redirect(base_url().'admin/dash/home');
        }
        else
        {
            $this->load->library('form_validation');
            $data = array();
            $this->form_validation->set_rules('username', 'Username' , 'required');
            $this->form_validation->set_rules('password', 'Password' , 'required');
            if($this->form_validation->run() == TRUE) {
                $user_auth = $this->input->post('username');
                $user_password = $this->input->post('password');
                $user_password = md5($user_password);
                $adminResult = $this->User_model->FindUserByArray(array('NAME' => $user_auth, 'LEVEL<' => '4' ));
                if(count($adminResult) > 0){
                    if($adminResult[0]['PASSWORD'] == $user_password)
                    {
                        //set login_attempt = 0
                        //add login history
                        // password is matched
                        $session_value = array(
                            'logged_in' => true,
                            'me' => $adminResult[0]
                        );
                        $this->session->set_userdata($session_value);
                        redirect(base_url().'admin/dash/home');
                    }
                    else
                    {
                        // password is inmatched
                        $this->User_model->UpdateUserLoginAttempt($adminResult[0]['ID']);
                        $resultLoginAttempt = $this->User_model->FindUserByArray(array('ID' => $adminResult[0]['ID']));
                        if($resultLoginAttempt[0]['LOGIN_ATTEMPT'] == 3)
                        {
                            //block user
                        }
                        //set error
                        $data['error'] = true;
                    }
                }
                else{
                    // id is not exists
                    $data['error'] = true;
                }
            }
            else{
                $data['error'] = false;
            }
            $this->load->view('admin/auth/login', $data);
        }
    }

    public function forgotpassword()
    {
        $this->load->view('admin/auth/forgotpassword');
    }


    public function register()
    {
        $this->load->view('admin/auth/register');
    }
}