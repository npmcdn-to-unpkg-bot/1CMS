<html>
<head>
    <title>Календарь с запланированными событиями (праздниками). Колекция Java скриптов. Библиотека в примерах.</title>
    <SCRIPT LANGUAGE="JAVASCRIPT">
        <!--
        //------------------------------------//
        // Далее вводите информцию своих событий //
        //-----------------------------------//
        var concertMonth = new Array(1, 3, 5)
        var concertDay = new Array(1, 8, 25)
        var concertInfo = new Array()
        //Количество праздников
        concertNum = 0
        /* При добавлении праздничной даты надо добавить месяц в var concertMonth = new Array
         и день в var concertDay = new Array
         и название праздника в var concertInfo = new Array.
         Для добавления нового события, например Старого нового года (13 января),
         надо сделать следующие изменения в приведенном коде:
         var concertMonth = new Array (1,> 1 <,2,3,4,5,6,7,8,9,10,11,12)
         var concertDay = new Array
         (1,> 13 <,23,8,1,1,12,26,2,24,28,17,12)
         var concertInfo = new Array ("Новый год"," > Старый новый год < ","День армии и флота","Женский день","День смеха","День трудящихся","День суверенитета Российской Федерации","День Военно-Морского
         флота","День ВДВ","Мой день рождения","День рождения WWW> <","Международный день студентов","День
         конституции")
         concertNum = > 13 < Количество праздников
         Изменения и добавления выделены > <
         цветом. Таким образом можно добавить любое количество событий.
         В примере приведен 1 праздник в каждом месяце, вы можете добавлять или удалять праздники для каждого месяца, при добавлении 1 праздника, меняйте цифру 12 на 13:*/

        var today = new Date
        var dayName = new Array("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб")
        var monthName = new Array("Январь", "Февраль", "Март", "Апрель", "Май", "June", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь")

        document.write("<P><FONT SIZE=3 FACE=ARIAL> <FONT SIZE=4>" + monthName[today.getMonth()] + "</FONT>" + "</FONT></P><P ALIGN=CENTER>")

        // find what day is the first day of this month
        day = today.getDay()
        result = (today.getDate() % 7) - 1
        if (result > day) {
            day += 7
        }
        firstDay = day - result

        // find how many days this month has (note Jan=0, Dec=11)
        if (today.getMonth() == 1) {
            // 1/26/1999, added code to deal with leap years
            thisYear = today.getYear() + 1900
            if (thisYear % 4 == 0) {
                if (thisYear % 100 == 0) {
                    if (thisYear % 400 == 0) {
                        daysInMonth = 29
                    }
                    else {
                        daysInMonth = 28
                    }
                }
                else {
                    daysInMonth = 29
                }
            }
            else {
                daysInMonth = 28
            }
        }
        else {
            if (today.getMonth() == 0 || today.getMonth() == 2 || today.getMonth() == 4 || today.getMonth() == 6 || today.getMonth() == 7 || today.getMonth() == 9 || today.getMonth() == 11) {
                daysInMonth = 31
            }
            else {
                daysInMonth = 30
            }
        }

        // display the calender
        document.write("<TABLE BORDER CELLSPACING=1 CELLPADDING=7 WIDTH=340><TR>")

        // display the names of the days at the top
        for (i = 0; i < 7; i++) {
            document.write("<TD WIDTH=5%><P ALIGN=CENTER>" + dayName[i] + "</P></TD>")
        }
        document.write("</TR><TR>")

        // write any blank boxes ahead of the first day
        for (i = 0; i < firstDay; i++) {
            document.write("<TD WIDTH=5%> </TD>")
        }
        // display the days
        d = firstDay
        for (i = 1; i <= daysInMonth; i++) {
            if (!(d < 7)) {
                document.write("<TR></TR>")
                d = 0
            }
            if (i == today.getDate()) {
                dispDay = '* ' + i + ' *'
            }
            else {
                dispDay = i
            }
            for (var y = 0; y < concertNum; y++) {
                if (i == concertDay[y] && (concertMonth[y] - 1) == today.getMonth())
                    dispDay = '<A HREF="#concertdesc">' + dispDay + '</A>'
            }
            document.write("<TD WIDTH=5%><P ALIGN=CENTER>" + dispDay + "</P></TD>")
            d++
        }
        if (d < 7) {
            for (i = d; i < 7; i++) {
                document.write("<TD WIDTH=5%> </TD>")
            }
        }
        document.write("</TR></TABLE>")
        // -->
    </SCRIPT>

    <a name="concertdesc"></a>

    <SCRIPT LANGUAGE="JAVASCRIPT">
        <!--
        // формат записи назначенных событий
        document.write("<P><oL>")
        for (var x = 0; x < concertNum; x++) {
            if (concertDay[x] > 0 && concertDay[x] <= 31)
                cDay = concertDay[x]
            else
                cDay = ""
            document.write("<LI><STRONG>" + monthName[concertMonth[x] - 1] + " " + cDay + "</STRONG> - " + concertInfo[x])
            document.write("</LI>")
        }
        document.write("</oL>")
        // -->
    </SCRIPT>
    </body>
</head>
</html>