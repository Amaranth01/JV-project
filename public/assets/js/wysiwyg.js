tinymce.init({
    selector: '#editor',
    height: 700,
    //Select plugins to include on load
    plugins: [
        'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
        'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'fullscreen', 'insertdatetime',
        'media', 'table', 'help'
    ],
    //toolbar customization
    toolbar: 'insertfile undo redo | styles | bold italic visualblocks| alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist | link image | preview | forecolor backcolor emoticons | fullscreen',

    //defines the allowed format
    images_file_types:'jpeg,jpg,png,gif,',

    link_default_target: '_blank'
});

