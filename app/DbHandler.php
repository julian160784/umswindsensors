<?php

class DbHandler
{
    private $conn;
    private $url;

    function __construct()
    {
        require_once 'koneksi2.php';
        $db = new DbConnection();
        $this->conn = $db->connect();
        $this->url = $db->url();
    }

    public function get_All_last_Wind()
    {
        $num = 0;
        $stringnya ="";
        $sql = "select * from sensor_logs ORDER BY id DESC LIMIT 36;";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) 
        {
            header('Content-Type: application/json');
            $data = array();
            while ($row = $result->fetch_assoc()) 
            {

                $stringnya = $row['parameter'];
                if ($stringnya=='bearing'|$stringnya=='wspeed'|$stringnya=='wspeed30'|$stringnya=='bearing30'|$stringnya=='wspeed60'|$stringnya=='bearing60'|$stringnya=='wspeed80'|$stringnya=='bearing80')
                $temp[$stringnya] = $row['nilai'];
            }
            $data[] = $temp;
            echo '{"results":'.json_encode($data).'}';
        }
        else
        {
            header('Content-Type: application/json');
            echo '{"results" : "0"}';
        }
    }
}
?>