/**
 * Convert a string to a Slug String
 **/
String.prototype.toSlug = function(ucfirst, fromSlug, whileTyping) {
    var str = this;
    str = str.toUpperCase();
    str = str.toLowerCase();
    //For Vietnamese Unicode
    str = str.replace(/[\u00E1\u00E0\u1EA1\u00E2\u1EA5\u1EAD\u0103\u1EAF\u1EB7\u1EA7\u1EB1\u1EA3\u00E3\u1EA9\u1EAB\u1EB3\u1EB5]/g, 'a');
    str = str.replace(/[\u00ED\u00EC\u1ECB\u1EC9\u0129]/g, 'i');
    str = str.replace(/[\u00F3\u00F2\u1ECD\u1ECF\u00F5\u00F4\u1ED1\u1ED3\u1ED9\u1ED5\u1ED7\u01A1\u1EDB\u1EDD\u1EE3\u1EDF\u1EE1]/g, 'o');
    str = str.replace(/[\u00FA\u00F9\u1EE5\u1EE7\u0169\u01B0\u1EE9\u1EEB\u1EF1\u1EED\u1EEF]/g, 'u');
    str = str.replace(/[\u0065\u00E9\u00E8\u1EB9\u1EBB\u1EBD\u00EA\u1EBF\u1EC1\u1EC7\u1EC3\u1EC5]/g, 'e');
    str = str.replace(/[\u00FD\u1EF3\u1EF5\u1EF7\u1EF9]/g, 'y');
    str = str.replace(/[\u0111]/g, 'd');
    str = str.replace(/[\u00E7\u0107\u0106]/g, 'c');
    str = str.replace(/[\u0142\u0141]/g, 'l');
    str = str.replace(/[\u015B\u015A]/g, 's');
    str = str.replace(/[\u017C\u017A\u017B\u0179]/g, 'z');
    str = str.replace(/[\u00F1]/g, 'n');
    str = str.replace(/[\u0153]/g, 'oe');
    str = str.replace(/[\u00E6]/g, 'ae');
    str = str.replace(/[\u00DF]/g, 'ss');

    if (fromSlug == true) {
        str = str.replace(/[-]/g, ' ');
    }

    str = str.replace(/[^a-z0-9\s\'\:\/\[\]_]/g, '');
    str = str.replace(/[\'\:\/\[\]-]+/g, ' ');
    str = str.replace(/[ ]/g, '-');

    if (whileTyping !== true) {

        if (str.charAt(str.length - 1) == '-') {
            str = str.substring(0, str.length - 1);
        }

        if (str.charAt(0) == '-') {
            str = str.substring(1, str.length);
        }
    }

    if (ucfirst == true) {
        var c = str.charAt(0);
        str = c.toUpperCase() + str.slice(1);
    }

    return str;
}

/**
 * Get parameter value by name
 * @param name
 * @returns {string}
 */
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "undefined" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

/**
 * Replace all string
 *
 * @param find
 * @param replace
 * @returns {string}
 */
String.prototype.replaceAll = function (find, replace) {
    var str = this;
    var regex = new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g');
    return str.replace(regex, replace);
};









/**
 * Copy String From a Text Field to Another Text Field
 */
function copyString(id_from, id_to, append) {
    $(id_from).keyup(function () {
        $(id_to).val($(id_from).val().trim());
    });
    $(id_from).change(function () {
        $(id_to).val($(id_from).val().trim());
    });
}

/**
 * Get the Prefix ID before @ in an Email Address
 **/
function getPrefixEmail(str_email) {
    var ind = str_email.indexOf("@");
    var my_slice = str_email.slice(0, ind);
    return my_slice;
}


/**
 * Check Count Words
 **/
function wordCountCheck(id_check, id_count, max) {
    $(id_check).bind('keyup change hover', function () {
        countWords(id_check, id_count, max);
    })
}

/**
 * Count Words Function
 **/
function countWords(id_check, id_count, max) {
    var s = $(id_check).val();
    if (s == '') {
        number = 0;
    } else {
        s = s.replace(/(^\s*)|(\s*$)/gi, "");
        s = s.replace(/[ ]{2,}/gi, " ");
        s = s.replace(/\n /, "\n");

        var number = s.split(' ').length;
        if (max > 0) {
            if (number >= max) {
                $(id_count).addClass('red');
            } else {
                $(id_count).removeClass('red');
            }
        }
    }
    $(id_count).text(number);
}

function autoResize(object, px) {
    var newheight;
    newheight = object.contentWindow.document.body.scrollHeight + px;
    object.height = (newheight) + "px";

}

function log($msg) {
    console.log($msg);
}