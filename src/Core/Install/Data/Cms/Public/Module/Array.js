let implode = (glue, pieces) => {
    return _('_').implode(glue, pieces);
}

let explode = (delimiter, string, limit) => {
    return _('_').explode(delimiter, string, limit);
}

export { implode, explode };