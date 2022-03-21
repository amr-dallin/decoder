<!DOCTYPE html>
<html>
    <head>
        <title>Decoder for Barcode</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    </head>
    <body>
        <div style="text-align: center; margin: 30px; font-size: 18px;">
            <form action="index.php" method="post" enctype="multipart/form-data">
                <strong>Загрузите последний файл из папки <code>Мухайбока\Inv</code>:</strong>
                <br/>
                <i>Примерное название, <code>inv_result_*.txt</code></i>
                <br/><br/>
                <input type="file" name="fileToUpload">
                <input type="submit" value="Отправить" name="submit">
            </form>
        </div>

        <?php
        if (!empty($_POST) && !empty($_FILES)) {
            echo '<hr/>';
            $file = file_get_contents($_FILES['fileToUpload']['tmp_name']);
            $sourceCodes = explode(PHP_EOL, $file);
            $resultCodes = [];
            foreach($sourceCodes as $sourceCode) {
                $sourceCode = trim($sourceCode);
                $length = strlen($sourceCode);
                $code = '';
                for ($i = 0; $i < $length; $i++) {
                    if ($i & 1) {
                        $code .= $sourceCode[$i];
                    }
                }
                $resultCodes[] = $code;
            }

            if (!empty($resultCodes)) {
                echo '<div style="margin: auto; margin-top: 30px; width: 500px;">';
                echo '<textarea style="width: 100%; height: 200px; overflow-y: auto;" id="foo">';
                foreach($resultCodes as $key => $resultCode) {
                    if (($key + 1) === count($resultCodes)) {
                        echo $resultCode;
                        break;
                    }
                    echo $resultCode . PHP_EOL;
                }
                echo '</textarea>';
                echo '<button class="btn" data-clipboard-target="#foo">Копировать</button>';
                echo '</div>';
            }
        }
        ?>

        <script>
            new ClipboardJS('.btn');
        </script>
    </body>
</html>