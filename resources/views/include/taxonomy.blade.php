// Get the reference to the input field
var elt = $('#taxonomy_id'); 

var taxonomy = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,    
    remote: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content'),
        },
        url: '{!!url("/")!!}' + '/api/find-taxonomy?keyword=%QUERY%',
        wildcard: '%QUERY%',                
    }
});
taxonomy.initialize();