
$(function() {
    // 載入檔案樹
    $.get('api/list_files.php', function(data) {
        function makeTree(arr) {
            let html = "<ul>";
            arr.forEach(function(item) {
                if(item.type == 'folder') {
                    html += `<li><b>${item.name}</b>${makeTree(item.children)}</li>`;
                } else {
                    html += `<li><a href="#" class="file-link" data-path="${item.path}">${item.name}</a></li>`;
                }
            });
            html += "</ul>";
            return html;
        }
        $("#fileTree").html(makeTree(data));
    });

    // 點擊檔案
    $(document).on('click', '.file-link', function(e) {
        e.preventDefault();
        let path = $(this).data('path');
        $("#docContent").html('載入中...');
        $.get('api/get_file.php', {path}, function(html) {
            $("#docContent").html(html);
        });
    });

    // 搜尋功能
    $("#search").on('keypress', function(e){
        if(e.which == 13){
            let q = $(this).val();
            $("#docContent").html('搜尋中...');
            $.get('api/search.php', {q}, function(res){
                let data = res;
                if (typeof res == 'string') data = JSON.parse(res);
                if(!data.length) {
                    $("#docContent").html('<p>沒有搜尋到內容</p>');
                } else {
                    let html = '<ul>';
                    data.forEach(function(item){
                        html += `<li><a href="#" class="file-link" data-path="${item.path}">${item.name}</a> <small>${item.snippet}</small></li>`;
                    });
                    html += '</ul>';
                    $("#docContent").html(html);
                }
            });
        }
    });
});
