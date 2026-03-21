document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('imageFile');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const imagePreview = document.getElementById('imagePreview');
    
    // input type="file" の内容が変更されたときに実行
    if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                // ファイル名を表示
                fileNameDisplay.textContent = file.name;

                // サムネイルプレビュー処理
                const reader = new FileReader();
                reader.onload = function(e) {
                    // 読み込みが完了したら、imgタグのsrcにデータURLを設定
                    imagePreview.src = e.target.result;
                    // imgタグを表示する
                    imagePreview.classList.remove('d-none');
                    imagePreview.classList.remove('d-none');
                };

                // ファイルをデータURLとして読み込み開始
                reader.readAsDataURL(file);

            } else { 
                fileNameDisplay.textContent = '選択されていません';
            }
        });
    }
});