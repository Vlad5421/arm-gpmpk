<?php
require_once 'ListMaker.php';


class Card extends ListMaker
{

    public $post_rm = array(
        'id_card' => '',
        'new_status' => 'rejected',
        'comment' => '',
        'page' => '',
        'date' => '',
        'id_time' => '',
        'time_str' => '',
        'id_fil' => '',
    );

    ////////////////////////
    function __construct()
    {
        if (empty($_SESSION['user'])) {
            $this->throw_away();
            die;
        } else {
            foreach ($_POST as $k => $v) {
                if (array_key_exists($k, $this->post_rm)) $this->post_rm[$k] = $v;
            }
            $this->post_rm['page'] = $_SERVER['DOCUMENT_ROOT'];
        }
    }

    function throw_away()
    {
        $s = $_SERVER['DOCUMENT_ROOT'];
        header("Location: $s");
    }


    function change_status()
    {
        global $bz;
        $new_stat_id = $this->statuses[$this->post_rm['new_status']]['id'];
        $new_comment = $this->post_rm['comment'];
        $id_card = $this->post_rm['id_card'];
        $sql = "UPDATE zapis_card SET `status`= :statuse, `comment`=:comment WHERE `id` = :id_card";
        $upd = $bz->prepare($sql);
        $upd = $upd->execute([':statuse' => $new_stat_id, ':comment' => $new_comment, ':id_card' => $id_card,]);

        return $upd;
    }
    function new_queue()
    {
        global $bz;
        if ($this->change_status()) {
            $date = $_POST['date'];
            $id_time = $_POST['id_time'];
            $id_fil = $_POST['id_fil'];
            $id_card = $_POST['id_card'];
            $id_own = $_SESSION['user']['id'];
            $sql = "INSERT INTO `pmpk_queue`(`date`, `id_time`, `id_filial`, `id_card`, `id_owner`) VALUES ('$date', '$id_time', '$id_fil', '$id_card', '$id_own')";
            $upd = $bz->prepare($sql);
            $upd = $upd->execute();
        } else {
            $upd = 'ошибка изменения статуса.';
        }

        return $upd;
    }

    function get_parrent_email_from_idcard()
    {
        $id_card = $this->post_rm['id_card'];
        $id_parr = $this->get_card_data_from_id($id_card)['id_parrent'];
        $par_data = $this->get_parrent_data_from_id($id_parr);
        $comment = $this->post_rm['comment'];
        return [$id_card, $par_data, $comment];
    }
    function send_email_after_change_status()
    {
        $email = $this->get_parrent_email_from_idcard();
    }
}
