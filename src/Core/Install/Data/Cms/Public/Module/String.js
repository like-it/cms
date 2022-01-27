let stristr = (haystack, needle, bool) => {
    return _('_').stristr(haystack, needle, bool);
}

let contains = (haystack, needle, bool) => {
    return _('_').stristr(haystack, needle, bool);
}

let str_replace = (search, replace, subject, count) => {
    return _('_').str_replace(search, replace, subject, count);
}

let replace = (search, replace, subject, count) => {
    return _('_').str_replace(search, replace, subject, count);
}

export { stristr, str_replace, contains, replace };