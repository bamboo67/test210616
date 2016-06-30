<?
$error = "";
$action = $_POST["action"];
if (!empty($action))
{
    $name = trim($name);
    $msg = trim($msg);
    if (empty($msg)) // если не введено сообщение
    {
        $action = "";
        $error = $error."<LI>Вы не ввели сообщение\n";
    }
    if (empty($name)) // если не введено имя
    {
        $action = "";
        $error = $error."<LI>Вы не ввели имя\n";
    }
    if (!empty($email))
        /* если введен e-mail, то проверяем с помощью регулярного выражения
        правильность ввода */
    {
        if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email))
        {
            $action = "";
            $error = $error."<LI> Неверно введен е-mail.&nbsр Введите e-mail
          в виде <i>softtime@softtime.ru</i> \n";
        }
    }

    $name = substr($_POST["name"],0,32);
    $name = htmlspecialchars(stripslashes($name)); // обрабатываем имя
    $city = substr($_POST["city"],0,32);
    $city = htmlspecialchars(stripslashes($city)); // обрабатываем город
    $email = substr($_POST["email"],0,32);
    $email = htmlspecialchars(stripslashes($email)); // обрабатываем e-mail
    $url = substr($_POST["url"],0,36);
    $url = htmlspecialchars(stripslashes($url)); // обрабатываем url-адрес
    $msg = substr($_POST["msg"],0,1024);
    $msg = htmlspecialchars(stripslashes($msg)); // обрабатываем сообщение

    if (empty($error)) // если ошибок нет, обрабатываем сообщение
    {
        $msg = nl2br($msg);
        $msg = str_replace("[u]","<u>",$msg);
        $msg = str_replace("[U]","<u>",$msg);
        $msg = str_replace("[i]","<i>",$msg);
        $msg = str_replace("[I]","<i>",$msg);
        $msg = str_replace("[b]","<B>",$msg);
        $msg = str_replace("[B]","<B>",$msg);
        $msg = str_replace("[sub]","<SUB>",$msg);
        $msg = str_replace("[SUB]","<SUB>",$msg);
        $msg = str_replace("[sup]","<SUP>",$msg);
        $msg = str_replace("[SUP]","<SUP>",$msg);
        $msg = str_replace("[/u]","</u>",$msg);
        $msg = str_replace("[/U]","</u>",$msg);
        $msg = str_replace("[/i]","</i>",$msg);
        $msg = str_replace("[/I]","</i>",$msg);
        $msg = str_replace("[/b]","</B>",$msg);
        $msg = str_replace("[/B]","</B>",$msg);
        $msg = str_replace("[/SUB]","</SUB>",$msg);
        $msg = str_replace("[/sub]","</SUB>",$msg);
        $msg = str_replace("[/SUP]","</SUP>",$msg);
        $msg = str_replace("[/sup]","</SUP>",$msg);
        $msg = eregi_replace("(.*)\\[url\\](.*)\\[/url\\](.*)","\\1<a
                       href=\\2>\\2</a>\\3",$msg);
        $msg = str_replace("\n"," ",$msg);
        $msg = str_replace("\r"," ",$msg);

        /* создаем файл с именем вида "rec.+время добавления сообщения" */
        $file = fopen("records/rec.".time(),"w");
        // записываем информацию в файл, по одной строчке на каждое поле
        fputs($file,$name."\n");
        fputs($file,$city."\n");
        fputs($file,$email."\n");
        fputs($file,$url."\n");
        fputs($file,$msg."\n");
        // закрываем файл
        fclose($file);

        print "<HTML><HEAD>\n";
        print "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=index.php'>\n";
        print "</HEAD></HTML>\n";
    }
}if (empty($action))
{
    ?>
    <HTML>
    <HEAD><meta charset="utf-8">
        <TITLE>Гостевая книга - добавление записи</TITLE>
    </HEAD&tg;
    <BODY>
    <H3>
        <? print "<center>"; ?>
        <font color=#1E90FF>Добавление записи</font>
    </H3>
    <?
    if (!empty($error))
        /* если есть ошибки, выводим сообщение об ошибках */
    {
        print "<P><font color=green>Во время добавления записи произошли
      следующие ошибки:</font></P>\n";
        print "<UL>\n";
        print $error;
        print "</UL>\n";
    }
    ?>
    <!-- пишем HTML-код формы добавления сообщений !-->
    <center>
        <table width=1 border=0>
            <form action=addrec.php method=post>
                <input type=hidden name=action value=post>
                <tr>
                    <td width=50%>Имя:<font color=red><sup>*</sup><font></td>
                    <td align=right>
                        <input type=text name=name maxlength=32 value='<? echo $name; ?>'>
                    </td>
                </tr>
                <tr>
                    <td width=50%>Город:</td>
                    <td align=right>
                        <input type=text name=city maxlength=32 value='<? echo $city;; ?>'>
                    </td>
                </tr>
                <tr>
                    <td width=50%>E-Mail:</td>
                    <td align=right>
                        <input type=text name=email maxlength=32 value='<? echo $email; ?>'>
                    </td>
                </tr>
                <tr>
                    <td width=50%>URL:</td>
                    <td align=right>
                        <input type=text name=url maxlength=36 value='<? echo $url; ?>'>
                    </td>
                </tr>
                <tr>
                    <td colspan=2>Сообщение:<font color=red<sup>*</sup></font><br>
                        <textarea cols=50 rows=8 name=msg><? echo $url; ?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan=2><input type=submit value='Добавить'></td>
                </tr>
            </form>
            <tr>
                <td colspan=2><font color=red><sup>*</sup></font> - поля,
                    обязательные для заполнения
                </td><td align=left>
        </table>
    </center>
    </BODY>
    </HTML>
<?
}
?>
