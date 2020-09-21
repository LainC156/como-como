(function() {

    function removeAccents(data) {
        console.log('data: ', data);
        if (data.normalize) {
            // Use I18n API if avaiable to split characters and accents, then remove
            // the accents wholesale. Note that we use the original data as well as
            // the new to allow for searching of either form.
            return data + ' ' + data
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }

        return data;
    }

    let searchType = $.fn.DataTable.ext.type.search;
    console.log('search: ', searchType);

    searchType.string = function(data) {
        return !data ?
            '' :
            typeof data === 'string' ?
            removeAccents(data) :
            data;
    };

    searchType.html = function(data) {
        return !data ?
            '' :
            typeof data === 'string' ?
            removeAccents(data.replace(/<.*?>/g, '')) :
            data;
    };

}());
