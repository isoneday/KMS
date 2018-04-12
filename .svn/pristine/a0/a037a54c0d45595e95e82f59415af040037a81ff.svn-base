<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('notification_helper');
    }

    public function index() {
        $m_merchant = $this->load->model("m_merchant");
        $data["title"] = "Merchant Register";
        $data['page'] = "merchant/v_merchant_register";
        $data["form_action"] = base_url() . "registration/register";
        $data["merc_category"] = $this->m_merchant->getMercCategory();
        /* $this->load->view('merchant/v_merchant_register', $data); */

        $fail = "";
        $success = "";

        $fail = $this->session->flashdata('fail');
        $success = $this->session->flashdata('success');

        $data['fail'] = $fail;
        $data['success'] = $success;
        $this->load->view('template/page', $data);
    }

    function encodeId($lastId) {
        $phrase = 'qaCyTEx';
        $timephrase = strtotime(date("Y-m-d H:i:s"));
        $coded = urlencode(base64_encode($lastId).$phrase.$timephrase);
        return $coded;
    }

    function decodeId($idEncoded) {
        $url = urldecode($idEncoded);
        $result = explode('qaCyTEx', $url);
        $idDecoded = base64_decode($result[0]);
        return $idDecoded;
    }

    public function register() {
        $this->load->library("form_validation");
        $m_merchant = $this->load->model("m_merchant");

        $data["merc_name"] = $this->input->post("merc_name");
        $data["merc_business_field"] = $this->input->post("merc_business_field");
        $data["merc_category_id"] = $this->input->post("merc_category_id");
        $data["merc_phone"] = $this->input->post("merc_phone");
        $data["merc_email"] = $this->input->post("merc_email");

        $datauser["user_real_name"]         = $data["merc_name"];
        $datauser["user_user_name"]         = $data["merc_email"];
        $datauser["user_email"]             = $data["merc_email"];
        $datauser["user_password"]          = md5($this->input->post("merc_pass"));
        $datauser["user_active_lang_code"]  = 'en';
        $datauser["insert_user_id"]         = '1';
        $datauser["insert_timestamp"]       = date("Y-m-d H:i:s");

        $lastGtfwId = $this->m_merchant->insetGtfwUser($datauser);

        $datagroup["usergroup_user_id"]     = $lastGtfwId;
        $datagroup["usergroup_group_id"]    = 2;

        $lastUserGroupId = $this->m_merchant->insertGtfwGroup($datagroup);

        $lastId         = $this->m_merchant->insertMerc($data);
        $encodedLastId  = $this->encodeId($lastId);

        $datamerchuser["mercuser_merc_id"]      = $lastId;
        $datamerchuser["mercuser_gtfw_user_id"] = $lastGtfwId;
        $datamerchuser["insert_user_id"]        = '1';
        $datamerchuser["insert_timestamp"]      = date("Y-m-d H:i:s");

        $this->m_merchant->insertMercUser($datamerchuser);

        if ($encodedLastId != null && $lastGtfwId != null) {
            $address = $this->input->post("merc_email");
            $name = $this->input->post("merc_name");
            $subject = 'Merchant Registration';
            $content = "Hi, " . $name . " ! <br /><br />";
            $content .= "Terima kasih telah melakukan pendaftaran, selanjutnya untuk melengkapi proses pendaftaran silahkan membaca proposal attachment yang kami lampirkan... 
                        <br />...
                        <br />...
                        <br />...
                        <br /> Redaksi registrasi disini...
                        <br />...
                        <br />...
                        <br />";
            $content .= "Apabila ada setuju, silahkan klik link persetujuan dibawah ini.<br />";
            $content .= "<a href='" . base_url() . "registration/register_confirmation/" . $encodedLastId . "'>Saya Setuju</a>";

            $message_mail = template_email($content, $subject);
            send_email_notification($address, $subject, $message_mail, $attachment);

            $this->session->set_flashdata('success', 'Proses pendaftaran berhasil, silahkan cek notifikasi email Anda!');
            redirect('home');
        } else {
            $this->session->set_flashdata('fail', 'Proses pendaftaran merchant gagal, silahkan cek data Anda kembali!');
            redirect('registration');
        }
    }

    function send_mail($data) {
        $id = $data['merc_id'];
        $name = $data['merc_name'];
        $address = $data['merc_email'];
        $attachment = base_url() . 'files/from_registration.pdf';
        $subject = 'Merchant Registration';
        $content = "Hi, " . $name . " ! <br /><br />";
        $content .= "Terima kasih telah melakukan pendaftaran, selanjutnya untuk melengkapi proses pendaftaran silahkan membaca proposal attachment yang kami lampirkan... 
                        <br />...
                        <br />...
                        <br />...
                        <br /> Redaksi registrasi disini...
                        <br />...
                        <br />...
                        <br />";
        $content .= "Apabila ada setuju, silahkan klik link persetujuan dibawah ini.<br />";
        $content .= "<a href='" . base_url() . "registration/register_confirmation/" . $id . "'>Saya Setuju</a>";

        $message_mail = template_email($content, $subject);
        send_email_notification($address, $subject, $message_mail, $attachment);
    }

    function register_confirmation($id) {
        $decodedId  = $this->decodeId($id);
        $query = $this->db->query("SELECT * FROM merc_registration WHERE merc_id = " . $decodedId);
        if ($query->num_rows() > 0) {
            $m_merchant = $this->load->model("m_merchant");
            $confirm_email = $this->m_merchant->confirm($decodedId);
            if ($confirm_email) {
                $fail = "";
                $success = "";

                $this->session->set_flashdata('success', 'Proses verifikasi berhasil, Anda sekarang dapat login ke aplikasi!');

                redirect('registration/register_success');
            } else {
                $this->session->set_flashdata('fail', 'Proses verifikasi Gagal, Silakan hubungi administrator');
                redirect('registration');
            }
        } else {
            echo "NO ID AVAILABLE";
        }
    }

    function register_success() {
        $data['title'] = "Registration Success";
        $data['page'] = "merchant/v_merchant_success";

        $fail = $this->session->flashdata('fail');
        $success = $this->session->flashdata('success');

        $data['fail'] = $fail;
        $data['success'] = $success;

        $this->load->view('template/page', $data);
    }

}
