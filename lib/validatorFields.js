function FenixNumeric(evt) {
    //asignamos el valor de la tecla a keynum
    if (window.event) {// IE
        keynum = evt.keyCode;
    } else {
        keynum = evt.which;
    }
    //comprobamos si se encuentra en el rango
    if ((keynum == 8) || (keynum == 37)) return true;
    if (keynum > 47 && keynum < 58) {
        return true;
    } else {
        return false;
    }
}

function FenixZero(event, field) {
    var str = field.value;
    if (str.length == 0) {
        field.value = "0";
        field.setSelectionRange(0, 1);
    }
}

function FenixFloat(e, field) {
    key = e.keyCode ? e.keyCode : e.which
    // backspace
    if (key == 8) return true
    // 0-9 a partir del .decimal
    if(field.value==".") {
        field.value="0";
        return false;
    }
    if (field.value != "") {
        if ((field.value.indexOf(".")) > 0) {
            //si tiene un punto valida dos digitos en la parte decimal
            if (key > 47 && key < 58) {
                if (field.value == "") return true
                //regexp = /[0-9]{1,10}[\.][0-9]{1,3}$/
                regexp = /[0-9]{2}$/
                return !(regexp.test(field.value))
            }else{
                return false
            }
        }
    }
    // 0-9
    if (key > 47 && key < 58) {
        if (field.value == "") return true
        regexp = /[0-9]{6}/
        return !(regexp.test(field.value))
    }
    // .
    if (key == 46) {
        if (field.value == "") return false
        regexp = /^[0-9]+$/
        return regexp.test(field.value)
    }
    // other key
    return false;
}

function FenixText(e) {
    var key = window.Event ? e.which : e.keyCode
    if ((key == 8) || (key == 13) || (key == 9)) return true;
    return (key == 32 /* espacio */
        || key == 33 /* ! */
        || key == 35 /* # */
        || key == 36 /* $ */
        || key == 37 /* % */
        || key == 38 /* & */
        || key == 40 /* ( */
        || key == 41 /* ) */
        || key == 42 /* * */
        || key == 43 /* + */
        || key == 44 /* , */
        || key == 45 /* - */
        || key == 46 /* . */
        || key == 47 /* / */
        || (key >= 48 && key <= 57) /* 0-9 */
        || key == 58 /* : */
        || key == 59 /* ; */
        || key == 60 /* < */
        || key == 61 /* = */
        || key == 62 /* > */
        || key == 63 /* ? */
        || key == 64 /* @ */
        || (key >= 65 && key <= 90) /* A-Z */
        || key == 95 /* _ */
        || (key >= 97 && key <= 122) /* a-z */
        || key == 161 /* ¡ */
        || key == 191 /* ¿ */
        || key == 193 /* Á */
        || key == 201 /* É */
        || key == 205 /* Í */
        || key == 211 /* Ó */
        || key == 218 /* Ú */
        || key == 225 /* á */
        || key == 233 /* é */
        || key == 237 /* í */
        || key == 243 /* ó */
        || key == 250 /* ú */
        || key == 209 /* Ñ */
        || key == 241 /* ñ */);
}

