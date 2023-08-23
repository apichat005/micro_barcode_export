<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew-Bold';
        font-style: normal;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabunNew_Bold.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew-BoldItalic';
        font-style: italic;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew-Italic';
        font-style: italic;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
    }

    * {
        font-family: "THSarabunNew";
    }
</style>

<body>
    <?php
    $data = base64_decode($product);
    $data = explode(',', $data);
    // get ข้อมูลจาก database โดย curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://apichatapi.ddns.net/api/pos/item_all.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"database\":\"data_store_1\"}");
    curl_setopt($ch, CURLOPT_POST, 1);
    $headers = [];
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    // ปิดการเชื่อมต่อ
    curl_close($ch);
    // แปลงข้อมูลจาก string เป็น array
    $result = json_decode($result);
    // สร้าง array ใหม่เพื่อเก็บข้อมูลที่ตรงกับ id ที่ส่งมาจาก cilent
    $array = [];
    foreach ($result as $key => $value) {
        foreach ($data as $key2 => $value2) {
            if ($value->pro_id == $value2) {
                array_push($array, $value);
            }
        }
    }
    // สร้างตัวแปรเพื่อเก็บข้อมูลที่จะใช้ในการพิมพ์
    $data = $array;
    ?>
    <table border="1" style="border-collapse: collapse;">
        <?php
        $count = 0;
        foreach ($data as $key => $value) {
            if ($count % 3 == 0) {
                echo '<tr>';
            }
        ?>
            <td
                width="6.2cm"
            >
                <table border="0"
                    style="border-collapse: collapse;width:100%;"
                >
                    <tr>
                        <td
                            width="60px"
                        >
                            <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?= $value->pro_barcode ?>" style="width:60px;height:60px;object-fit:conver;">
                            </img>
                        </td>
                        <td
                            style="vertical-align: text-top;"
                        >
                            <div style="font-size: 13pt;position:relative;top:3px"><?= $value->pro_barcode ?></div>
                            <div style="font-size: 12pt;position:relative;"><?= strlen($value->pro_name) > 25 ? mb_substr($value->pro_name, 0, 25, 'utf8') . "\n" : $value->pro_name ?></div>
                        </td>
                        <td style="vertical-align: text-top;">
                            <div style="font-size: 13pt;position:relative;top:3px">ราคา</div>
                            <div style="font-size: 20pt;position:relative;top:-10px;font-family:THSarabunNew"><?= number_format($value->price, 2) ?></div>
                        </td>
                    </tr>
                </table>
            </td>
        <?php
            $count++;
            if ($count % 3 == 0) {
                echo '</tr>';
            }
        }
        ?>
    </table>
</body>

</html>
