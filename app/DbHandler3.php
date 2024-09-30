<?php

class DbHandler3
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

    public function get_All_last_pressure()
    {
        $num = 0;
        $i = 1;
        $stringnya ="";
        $stringnya1 ="";
        $sql = "select * from sensor_logs ORDER BY id DESC LIMIT 80000;";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0)
        {
            header('Content-Type: application/json');
            $data = array();
            while ($row = $result->fetch_assoc()) 
            {
                $stringnya1 = $row['parameter'];
                if ($stringnya1 =='press')
                {
                    $stringnya = $row['created_at'];
                    $stringnya = substr($stringnya, 11, 5);
                    if ($stringnya=='00:00' | $stringnya=='01:00' | $stringnya=='02:00' | $stringnya=='03:00' | $stringnya=='04:00' | 
                    $stringnya=='05:00' | $stringnya=='06:00' | $stringnya=='07:00' | $stringnya=='08:00' | $stringnya=='09:00' | 
                    $stringnya=='10:00' | $stringnya=='11:00' | $stringnya=='12:00' | $stringnya=='13:00' | $stringnya=='14:00' | 
                    $stringnya=='15:00' | $stringnya=='16:00' | $stringnya=='17:00' | $stringnya=='18:00' | $stringnya=='19:00' | 
                    $stringnya=='20:00' | $stringnya=='21:00' | $stringnya=='22:00' | $stringnya=='23:00')
                    {
                        $stringnya1 = 'p' . strval($i);
                        $temp[$stringnya1] =  $stringnya;
                        $stringnya1 = strval($i);
                        $temp[$stringnya1] = $row['nilai'];
                        $i++;
                    }
                }

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
    public function get_average_wind_12hrs()
    {
        $num = 0;
        $i = 0;
        $j = 0;
        $k = 0;
        $l = 0;
        $stringnya ="";
        $stringnya1 ="";
        $avg_80 = 0;
        $avg_60 = 0;
        $avg_30 = 0;
        $avg_10 = 0;
        $data = array();
        $sql = "select * from sensor_logs ORDER BY id DESC LIMIT 80000;";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0)
        {
            header('Content-Type: application/json');
            while ($row = $result->fetch_assoc()) 
            {
                $stringnya1 = $row['parameter'];
                if ($stringnya1 =='avg_wind80')
                {
                    $avg_80 = strval($avg_80 + $row['nilai']);
                    $i++;
                    if($i == 60) 
                    {
                        $temp["1"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 120)
                    {
                        $temp["5"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 180)
                    {
                        $temp["9"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 240)
                    {
                        $temp["13"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 300)
                    {
                        $temp["17"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 360)
                    {
                        $temp["21"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 420)
                    {
                        $temp["25"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 480)
                    {
                        $temp["29"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 540)
                    {
                        $temp["33"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 600)
                    {
                        $temp["37"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 660)
                    {
                        $temp["41"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                    elseif($i == 720)
                    {
                        $temp["45"] = strval(round($avg_80/60,1));
                        $avg_80 = 0;
                    }
                }
                if ($stringnya1 =='avg_wind60')
                {
                    $avg_60 = $avg_60 + $row['nilai'];
                    $j++;
                    if($j == 60) 
                    {
                        $temp["2"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 120)
                    {
                        $temp["6"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 180)
                    {
                        $temp["10"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 240)
                    {
                        $temp["14"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 300)
                    {
                        $temp["18"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 360)
                    {
                        $temp["22"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 420)
                    {
                        $temp["26"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 480)
                    {
                        $temp["30"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 540)
                    {
                        $temp["34"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 600)
                    {
                        $temp["38"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 660)
                    {
                        $temp["42"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                    elseif($j == 720)
                    {
                        $temp["46"] = strval(round($avg_60/60,1));
                        $avg_60 = 0;
                    }
                }
                if ($stringnya1 =='avg_wind30')
                {
                    $avg_30 = $avg_30 + $row['nilai'];
                    $k++;
                    if($k == 60) 
                    {
                        $temp["3"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 120)
                    {
                        $temp["7"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 180)
                    {
                        $temp["11"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 240)
                    {
                        $temp["15"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 300)
                    {
                        $temp["19"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 360)
                    {
                        $temp["23"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 420)
                    {
                        $temp["27"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 480)
                    {
                        $temp["31"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 540)
                    {
                        $temp["35"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 600)
                    {
                        $temp["39"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 660)
                    {
                        $temp["43"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                    elseif($k == 720)
                    {
                        $temp["47"] = strval(round($avg_30/60,1));
                        $avg_30 = 0;
                    }
                }
                if ($stringnya1 =='wlatest')
                {
                    $avg_10 = $avg_10 + $row['nilai'];
                    $l++;
                    if($l == 60) 
                    {
                        $temp["4"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 120)
                    {
                        $temp["8"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 180)
                    {
                        $temp["12"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 240)
                    {
                        $temp["16"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 300)
                    {
                        $temp["20"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 360)
                    {
                        $temp["24"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 420)
                    {
                        $temp["28"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 480)
                    {
                        $temp["32"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 540)
                    {
                        $temp["36"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 600)
                    {
                        $temp["40"] = strval(round($avg_10/60,1));
                        $avg10 = 0;
                    }
                    elseif($l == 660)
                    {
                        $temp["44"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                    elseif($l == 720)
                    {
                        $temp["48"] = strval(round($avg_10/60,1));
                        $avg_10 = 0;
                    }
                }
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