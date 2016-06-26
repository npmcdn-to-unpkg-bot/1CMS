<html>
<head>
    <title>Время.</title>
</head>
<body onLoad="myclock()">
<script language="JavaScript">
    <!--
    function myclock()
    {
        ndata=new Date()
// Получение показаний часов, минут и секунд
        hours= ndata.getHours();
        mins= ndata.getMinutes();
        secs= ndata.getSeconds();
// Дополнение показаний нулем слева
        if (hours < 10) {hours = "0" + hours }
        if (mins < 10) {mins = "0" + mins }
        if (secs < 10) {secs = "0" + secs }
// Суммирование всех данных для вывода
        datastr =hours+":" + mins+":" +secs
// Запись данных
        document.clockexam.clock.value = " "+datastr;
// Вызов функции с интервалом 1000 ms
        setTimeout("myclock()", 1000);
    }
    -->
</script>
<form name="clockexam"><input type="text" size="9" name="clock"></form>
</body>
</html>