<script>
    var assocArr = [];

    assocArr[0] = new Array("", "один", "два", "три", "четыри", "пять", "шесть", "семь", "восемь", "девять");
    assocArr["d"] = new Array("десять", "одинадцать", "двенадцать", "тринадцать", "четырнадцать", "пятнадцать", "шеснадцать", "семнадцать", "восемнадцать", "девятнадцать");
    assocArr[1] = new Array("", "", "двадцать", "тридцать", "сорок", "пятьдесят", "шестьдесят","семьдесят", "восемьдесят", "девяносто");
    assocArr[2] = new Array("", "сто", "двести", "триста", "четыреста", "пятьсот", "шестьсот","семьсот", "восемьсот", "девятьсот");
    assocArr["s"] = new Array("", "одна", "две");
    assocArr[3] = new Array("тысяч", "тысяча", "тысячи", "тысячи", "тысячи", "тысяч", "тысяч","тысяч", "тысяч", "тысяч", "");

    
    function numToWord(number) {
    var resp = "",
        numArr = [],
        flag = true;
    if (isNaN(number) || number < 1 || number > 9999) {
        return "Invalid input!";
    }
    for (; number != 0; number = Math.floor(number / 10)) {
        numArr.push(number % 10);
    }
    for (var i = numArr.length - 1; i >= 0 ; i--) {
        if (flag) {
            if (numArr[i] == 1 && i == 1 || numArr[i] == 1 && i == 4) {
                flag = false;
            } else {
                resp += digitToWord(i, numArr[i], 0);
            }
        } else {
            resp += digitToWord("d", numArr[i], i);
            flag = true;
        }
    }
    return resp.trim();
}

function digitToWord(digit, offset, char) {
    var resp = "";
    switch (digit) {
        case 3:
            resp += (offset == 1 || offset == 2 ? assocArr["s"][offset] : assocArr[0][offset]) + " ";
            break;
        case 4:
            digit = 1;
            break;
        case "d":
            resp += assocArr[digit][offset] + " ";
            digit = char;
            offset = 0;
            break;
    }
    return resp + assocArr[digit][offset] + " ";
}

function myFunction() {
    document.getElementById("demo").innerHTML = numToWord(parseFloat(document.getElementById("num").value));
}
</script>


<form>
  Число:<br>
  <input type="number" id="num" name="num"><br>
  <input onclick="myFunction()" type="button" value="Тык">
</form>
<p id="demo"></p>

