<?
$uploaddir = __DIR__ .'/../upload/'; // инициализ.переменн.для хранения строки абсолютного пути к файлу

f_fileMoveUploaded($uploaddir); // вызов функции

 /* // Можно сделать и вот так,более просто:  
if($_SERVER['REQUEST_METHOD']=='POST'){ // если была отправлена форма с загрузкой определенного файла на сервер, то:
echo "<pre>"; print_r($_FILES); echo "<pre>"; //только для наглядности просмотреть что в глобальной переменной (сведения о загруженном на сервер файле)
    
  $tmp_name = $_FILES['user_file']['tmp_name'];
  $name = $_FILES['user_file']['name'];
  move_uploaded_file($tmp_name, 'upload/'.$name); // copy($tmp_name, 'upload/'.$name);- можно и через эту функцию,но тогда дополнит.с проверкой через ф-ю is_uploaded_file($filename);
*/ 
?>
<form action='<?= $_SERVER['REQUEST_URI'] ?>' method='POST' enctype='multipart/form-data'>
  <input type='file' name='user_file[]'> <br>
  <!-- <input type='file' name='user_file[]'> --> <!-- если надо второе поле для загрузки, чтобы отправлять сразу 2 файла -->
  <input type='submit' value='Send File'>
</form> <!-- форма загрузки Юзером файлов на сервер -->

<? // Выводим сообщения об Успешности/Не успешности загрузки файла(ов)
if($_SERVER['REQUEST_METHOD']!=='POST') { echo " ";} //если не было POST (т.е.не была отправлена форма с файлом на загрузку),- ничего не выводить (это чтобы ничего не отображалось,если только зашел на станицу и форму не отправлял)
  elseif(!f_fileMoveUploaded($uploaddir))  {echo "Файл Не был загружен! Возможно его размер слишком велик"; } //если ф-я по перемещению файла с врем.папки на сервере в указанную папку сайта Не отработала(т.е.перемещение Не осуществилось), то сообщение ою этом
else { echo "Файл: $name (" ,round($size_file/1024/1024, 2), " MB) был успешно загружен!"; } // иначе успех, файл загрузился и мы его переместили в нашу папку.Ф-я round -округляет результат до указанного знака после запятой
?>