<?php
// Function to convert ascii to binary.
function getBinary($ascii) {
    $bin = decbin($ascii);
    $arr_bin = str_split($bin);

    $nol = 8 - count($arr_bin);
    $str_nol = "";

    for($i=0; $i<$nol; $i++) {
        $str_nol .= "0";
    }

    $bin = $str_nol . $bin;

    return $bin;
}

// Function to convert binary to text.
function binToText($bin) {
	$text = array();
	$bin = explode(" ", $bin);
    
    for($i=0; count($bin)>$i; $i++) {
        $text[] = chr(bindec($bin[$i]));
    }
		
	return implode($text);
}

// Function to get chippertext.
function getChipper($bin_pt, $bin_kt) {
    // Initialize
    $arr_pt = str_split(implode('', $bin_pt));
    $arr_kt = str_split(implode('', $bin_kt));

    $str_chipper = "";

    // Get string chippertext.
    for($i=0; $i<count($arr_pt); $i++) {
        $str_chipper .= ($arr_pt[$i] === $arr_kt[$i] ? '0' : '1');
    }

    $arr_chipper = str_split($str_chipper, 8);

    return $arr_chipper;
}

if(isset($_POST['submit'])) {
    // Initialize.
    $plain_text = $_POST['txt'];
    $key_text = "";

    $arr_key = str_split($_POST['txt2']);
    $arr_pt = str_split($plain_text);

    // Get binary.
    $bin_pt = array();
    $bin_kt = array();

    for($i=0; $i<count($arr_pt); $i++) {
        $key_text .= $arr_key[$i%count($arr_key)];

        $bin_pt[] = getBinary(ord($arr_pt[$i]));
        $bin_kt[] = getBinary(ord($arr_key[$i%5]));
    }

    $arr_kt = str_split($key_text);

    // Get chippertext.
    $bin_ct = getChipper($bin_pt, $bin_kt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php if(isset($_POST['submit'])) { ?>
    <h4>Encrypt</h4>
    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <td>Plain Text</td>
                <td><?php echo $_POST['txt']; ?></td>
                <td>
                <?php
                    $i = 1;
                    foreach($bin_pt as $bin) {
                        echo $bin . ($i === count($bin_pt) ? '' : '-');

                        $i++;
                    }
                ?>
                </td>
            </tr>

            <tr>
                <td>Key</td>
                <td>
                <?php
                    foreach($arr_kt as $letter) {
                        echo $letter;
                    }
                ?>
                </td>
                <td>
                <?php
                    $i = 1;
                    foreach($bin_kt as $bin) {
                        echo $bin . ($i === count($bin_kt) ? '' : '-');

                        $i++;
                    }
                ?>
                </td>
            </tr>

            <tr>
                <td>Chipper</td>
                <td>
                <?php
                    foreach($bin_ct as $bin) {
                        echo binToText($bin);
                    }
                ?>
                </td>
                <td>
                <?php
                    $i = 1;
                    foreach($bin_ct as $bin) {
                        echo $bin . ($i === count($bin_ct) ? '' : '-');

                        $i++;
                    }
                ?>
                </td>
            </tr>
        </tbody>
    </table>   
    <a href="enkripsi.php">Kembali</a>
    <?php } else { ?>
    <form action="enkripsi.php" method="POST">
        <p>
            <label>Plaintext</label>
            <input type="text" name="txt">
        </p>
        <p>
            <label>Key</label>
            <input type="text" name="txt2">
        </p>
        <p>
            <button type="submit" name="submit">Enkripsi</button>
        </p>
    </form>
    <?php } ?>
</body>
</html>