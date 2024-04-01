<?php

class ListMaker
{

    private $prichs = [
        'oopsh' => 'Определение образовательной программы школьника',
        'oopd' => 'Определение образовательной программы дошкольника',
        'gia' => 'Определение условий прохождения ГИА',
        'mse1' => 'Первичное освидетельствование на МСЭ',
        'mse2' => 'Повторное освидетельствование на МСЭ',
    ];
    public $get_rm = array(
        'page' => 'list_cards',
        'list_status' => 'new',
        'id_card' => '',
    );
    public $pages = array(
        'list_cards' => 'pages/page_list_card.php',
        'check_card' => 'pages/page_check_card.php',
        'page_auth' => 'pages/page_auth.php',
        'appointment' => 'pages/page_appointment.php',
        'appointment_end' => 'pages/appointment_end.php',
        'remake-time' => 'pages/remake-time.php',
        'list-times' => 'pages/list-times.php',
    );
    public $statuses = array(
        'new' => [
            'id' => 0,
            'str' => 'Не обработанные',
            'link' => 'arm.php?list_status=new',
        ],
        'in_queue' => [
            'id' => 1,
            'str' => 'Записаные',
            'link' => 'arm.php?list_status=in_queue',
        ],
        'rejected' => [
            'id' => 2,
            'str' => 'Отклонённые',
            'link' => 'arm.php?list_status=rejected',
        ],
        'arhived' => [
            'id' => 3,
            'str' => 'В архиве',
            'link' => 'arm.php?list_status=arhived',
        ],
    );



    ////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {
        if (empty($_SESSION['user']))
            $this->get_rm['page'] = 'page_auth';
        else {
            foreach ($_GET as $k => $v) {
                if (array_key_exists($k, $this->get_rm)) $this->get_rm[$k] = $v;
            }
        }
    }

    function return_get_rm()
    {
        return $this->get_rm;
    }

    function get_stat()
    {
        $s = $this->get_rm['list_status'];
        $stat = $this->statuses[$s];
        return $stat;
    }

    function get_page()
    {
        $p = $this->get_rm['page'];
        $page = $this->pages[$p];
        return $page;
    }

    function make_list_param($fioreb = null)
    {
        global $bz;
        $s = $this->get_stat()['id'];

        // Объект СТАТМЕНТ для получения записей
        if ($fioreb != null) {
            $SQL = "SELECT * FROM zapis_card WHERE `fioreb` LIKE :fior ORDER BY `id` DESC";
            $params = ['fior' => '%' . $fioreb . '%'];
        } else {
            $SQL = "SELECT * FROM zapis_card WHERE `status` = :stat AND `date` > CURRENT_DATE() - INTERVAL 90 DAY ORDER BY `id` DESC";
            $params = ['stat' => $s];
        }

        $cards = $bz->prepare($SQL);
        $cards->execute($params);

        return $cards->fetchAll();
    }

    function get_card_data_from_id($id)
    {
        global $bz;
        // Получение из БД данных запси о ребенке
        $stmt = $bz->query("SELECT * FROM zapis_card WHERE `id` = '$id'");
        $s = $stmt->fetch();
        return $s;
    }
    function get_parrent_data_from_id($id_p)
    {
        global $bz;
        // Получение из бд данных о родителе
        $stmt2 = $bz->query("SELECT * FROM parrents WHERE `id` = '$id_p'");
        $parrent = $stmt2->fetch();
        return $parrent;
    }
    function get_queue_from_id_card($id)
    {
        global $bz;
        $stmt = $bz->query("SELECT `date`, `date_creation`, `id_time` FROM pmpk_queue WHERE `id_card` = '$id'");
        $s = $stmt->fetch(); // данные из таблицы queue
        
        $id_time = $s['id_time'];
        $sql = $bz->query("SELECT `time_start` FROM pmpk_time WHERE `id` = '$id_time'");
        $s['time'] = $sql->fetch();
        return $s;
    }

    function make_checked_card($id)
    {
        // Данные ребенка(карты)
        $s = $this->get_card_data_from_id($id);
        // Преобразуем причину в заявке для человекопонятного представления
        if (array_key_exists($s['prich'], $this->prichs)) {
            $s['prich'] = $this->prichs[$s['prich']];
        }
        $queue = $s['status'] == 1 ? $this->get_queue_from_id_card($id) : false;      

        // Получение из бд данных о родителе
        $id_p = $s['id_parrent'];
        $parrent = $this->get_parrent_data_from_id($id_p);

        // Получение изобаржений и ссылок на изображения
        if (count(glob("uploads/$id-*")) != 0) {
            $doc_source = false;
            $files = glob("uploads/$id-*"); 
        } else {
            $doc_source = true;
            // Получение изображений из архива
            $dir = 'https://cloud.psygorodomsk.ru/'; // Папка с изображениями на сервере
            // $f = $arr = glob($dir, GLOB_BRACE);
            // $f = scandir($dir."478-*");

            $sURL = "https://cloud.psygorodomsk.ru/index.php"; // URL-адрес POST
            $sPD = "id=$id"; // Данные POST
            $aHTTP = array(
            'http' => // Обертка, которая будет использоваться
                array(
                'method'  => 'POST', // Метод запроса
                // Ниже задаются заголовки запроса
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $sPD
            )
            );
            $context = stream_context_create($aHTTP);
            $contents = json_decode( file_get_contents($sURL, false, $context) );
	    if ($contents){
            $files = count($contents) == 0 ? false : $contents;
            } else {
		$files = ["no_files"];
	    }

        }
        

        // Получение строкового названия статуса заявки
        $stat_strings =  array_column($this->statuses, 'str', 'id');
        $status_str = $stat_strings[$s['status']];

        return [
            'card' => $s,
            'parrent' => $parrent,
            'files' => $files,
            'status_str' => $status_str,
            'queue' => $queue,
            'doc_source' => $doc_source
        ];
    }


    private function getDocFromArchive()
    {

    }
}
