document.addEventListener('DOMContentLoaded', () => {
    // 画像1~5のと表示箇所(画像と名前)の配列を作成
    const fileInputs = [];
    const fileNameDisplays = [];
    const imagePreviews = [];
    
    for(let i=1; i<=5; i++){
        const dispElement = document.getElementById(`fileNameDisplay${i}`);
        const imgElement = document.getElementById(`imageFile${i}`);
        const previewElement = document.getElementById(`imagePreview${i}`);
        fileInputs.push(imgElement);
        fileNameDisplays.push(dispElement);
        imagePreviews.push(previewElement);
    }
    
    // input type="file" の内容が変更されたときに実行
    if (fileInputs.length > 0 && fileNameDisplays.length > 0) {
        fileInputs.forEach((fileInput,index,array) =>{
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];

                    // ファイル名を表示
                    fileNameDisplays[index].textContent = file.name;

                    // サムネイルプレビュー処理
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // 読み込みが完了したら、imgタグのsrcにデータURLを設定
                        imagePreviews[index].src = e.target.result;
                        // imgタグを表示する
                        imagePreviews[index].classList.remove('d-none');
                        imagePreviews[index].classList.remove('d-none');
                    };

                    // ファイルをデータURLとして読み込み開始
                    reader.readAsDataURL(file);

                } else { 
                    fileNameDisplays[index].textContent = '選択されていません';
                }
            });
        })
    }

});

function CheckImagesSize(){
    var image_size = [];
    for (let i = 1; i <= 5; i++) {
        $('#imageFile' + i).prop('files')[0] ? image_size.push($('#imageFile' + i).prop('files')[0].size) : image_size.push(0);
    }
    var total_image_size = image_size.reduce((sum, element) => sum + element, 0);
    console.log(total_image_size);
    if(total_image_size >= 8000000){
        alert("ファイル合計の上限サイズ8MBを超えています");
        return;
    }else{
        document.getElementById('frm').submit();
    }
}