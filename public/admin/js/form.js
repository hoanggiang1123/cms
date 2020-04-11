function to_slug(str) {
    str = str.toLowerCase();     
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}
$('#post-title').keyup(function(e) {
    if(task === 'edit') return;
    let slug = to_slug($(this).val());
    $('#post-slug').val(slug);
})

var createTags = {
    tags: tagArr,
    init:function() {
        this.clickAdd();
        this.addTag();
        this.addHiddenTag();
        this.addUiTag();
        this.removeTag();
    },
    clickAdd:function() {
        var that = this;
        if(document.getElementById('addTag')) {
            document.getElementById('addTag').addEventListener('click',function(e) {
                e.preventDefault();
                let input = document.getElementById('inputTag');
                let tag = input.value.trim();
                if(tag == '') return;
                let index = that.tags.indexOf(tag);
                if(index > -1) return;
                that.tags.push(tag);
                input.value = '';
                that.addHiddenTag();
                that.addUiTag();
                that.removeTag();
            });
        }
    },
    addTag: function() {
       var that = this;
       if(document.getElementById('inputTag')) {
            document.getElementById('inputTag').addEventListener('keydown',function(e) {
                if(e.keyCode == 13 || e.keyCode == 188) {
                    e.preventDefault();
                    let tag = this.value.trim();
                    if(tag == '') return;
                    let index = that.tags.indexOf(tag);
                    if(index > -1) return;
                    that.tags.push(tag);
                    this.value = '';
                    that.addHiddenTag();
                    that.addUiTag();
                    that.removeTag();
                }
            });
       }
        
    },
    addHiddenTag: function() {
        let tagArr = this.tags;
        let tags = tagArr.join(',');
        if(document.getElementById('tags')) {
            document.getElementById('tags').value = tags;
        }
    },
    addUiTag: function() {
        let tagArr = this.tags;
        let tagHtml = '';
        for(let i = 0; i < tagArr.length; i++) {
            tagHtml += `<span class="tag badge badge-secondary badge-xlg font-normal" >${tagArr[i]}<span data-index="${i}" data-role="remove" class="rm-tag"></span></span>`;
        }
        if(tagArr.length != 0 && document.querySelector('.bootstrap-tagsinput')) document.querySelector('.bootstrap-tagsinput').style.display = 'block';
        
        if(document.querySelector('.bootstrap-tagsinput')) document.querySelector('.bootstrap-tagsinput').innerHTML = tagHtml;
    },
    removeTag: function() {
        var that = this;
        let rm = document.querySelectorAll('.rm-tag');
        if(rm.length == 0) return;
        for(let i = 0; i < rm.length; i++) {
            rm[i].addEventListener('click',function() {
                let index = this.getAttribute('data-index');
                that.tags.splice(index,1);
                that.addHiddenTag();
                that.addUiTag();
                if(that.tags.length == 0) {
                    document.querySelector('.bootstrap-tagsinput').style.display = 'none';
                }
                that.removeTag();
            });
        }
    }
}

createTags.init();

var _token = document.querySelector('input[name=_token]').value;
var url = document.getElementById('dropzone').getAttribute('action');
var clickUpload = document.getElementById('clickUpload');
var addMedia = document.getElementById('upload-thumb');
var imagesContainer = document.querySelector('.append-images');
var attachDetail = document.querySelector('.attach-detail');
var featureThumb = document.getElementById('feature-thumb');
var removeFeauture = document.getElementById('remove-thumb');
var files = document.getElementById('files');

var openMedia = false;
var data = [];
var selectedItem = [];
var editItem = {};
var next_page_url = null;
var mode = null;

if(clickUpload) {
    clickUpload.addEventListener('click', function() {
        document.getElementById('files').click();
    })
}
if(files) {
    files.addEventListener('change', function() {
        document.getElementById('media-tab').click();
        var files = document.getElementById('files').files;
        for(let i = 0; i < files.length; i++) {
            uploadFile(files[i],i);
        }
    })
}

function uploadFile(file, index) {
    
    var http = new XMLHttpRequest;
    var dzPreview = document.createElement('div');
    dzPreview.className = "dz-image-preview";
    dzPreview.setAttribute('aria-checked',false);
    dzPreview.setAttribute('onclick','selectThumb(this)');

    var dzImage = document.createElement('div');
    dzImage.className = 'dz-image';
    var image = document.createElement('img');
    image.src = '';
    dzImage.appendChild(image);

    var dzProgress = document.createElement('div');
    dzProgress.className = 'dz-progress border-1 brc-yellow-tp2';
    dzProgress.style.height = '0.75rem';
    var dzProgressBar = document.createElement('div');
    dzProgressBar.className = 'dz-progress-bar bgc-success';
    dzProgress.appendChild(dzProgressBar);


    var dzSuccessMark = document.createElement('div');
    dzSuccessMark.className = 'dz-success-mark';
    dzSuccessMark.innerHTML = '<span class="fa-stack fa-lg text-150"><i class="fa fa-circle fa-stack-2x text-white"></i><i class="fa fa-check fa-stack-1x fa-inverse text-success-m1"></i></span>';

    var dzErrorMark = document.createElement('div');
    dzErrorMark.className = 'dz-error-mark';
    dzErrorMark.innerHTML = '<span class="fa-stack fa-lg text-150"><i class="fa fa-circle fa-stack-2x text-danger-m3"></i><i class="fas fa-exclamation fa-stack-1x fa-inverse text-white"></i></span>';

    dzPreview.appendChild(dzImage);
    dzPreview.appendChild(dzProgress);
    dzPreview.appendChild(dzSuccessMark);
    dzPreview.appendChild(dzErrorMark);
    imagesContainer.prepend(dzPreview);

    let reader = new FileReader();
    reader.addEventListener('load', function() {
        image.src = reader.result;
    })

    if(file) reader.readAsDataURL(file);

    http.upload.addEventListener('progress', function(event) {
        var fileLoad = event.loaded;
        var fileTotal = event.total;
        var fileProgress = parseInt((fileLoad/fileTotal)*100) || 0;

        dzProgressBar.style.width = fileProgress + '%';
        if(fileProgress == 100) {
            dzPreview.className += ' dz-complete';
        } 


    }, false)
    var formData = new FormData();
    formData.append('file',file);
    formData.append('folder', controllerName);
    formData.append('_token',_token);   
    http.open('POST',url,true);
    http.send(formData);

    http.onreadystatechange = function(event) {
        if(http.readyState == 4 && http.status == 200) {
            try {
                dzPreview.className += ' dz-success';
                let res = JSON.parse(http.responseText);
                data.push(res.data);
                dzPreview.setAttribute('data-id',res.data.id);
                let link = '/images/'+ res.data.filename;
                image.src = link;

                setTimeout(function() {
                    dzPreview.classList.remove('dz-success');
                },1500);
            }catch (e){
                dzPreview.className += ' dz-error';
                setTimeout(function() {
                    dzPreview.classList.remove('dz-error');
                    dzPreview.remove();
                },1500);
            }
            
        }
        //xmlHttp.removeEventListener('progress');
    }
}

if(addMedia) {
    addMedia.addEventListener('click',function() {
        mode = 'post';
        if(openMedia == true){
            selectedItem = [];
            resetChecked();
            attachDetail.innerHTML = '';
        } else {
            var url = this.getAttribute('data-url');
            ajaxRequest('GET','',url,loadImages);
            openMedia = true;
        }
        
    });
}

if(featureThumb) {
    featureThumb.addEventListener('click',function() {
        addMedia.click();
        mode = 'thumb';
    })
}
if(removeFeauture) {
    removeFeauture.addEventListener('click', function() {
        document.querySelector('.thumbnail img').src = '';
        document.querySelector('input[name=thumb]').value = '';
        removeFeauture.style.display = 'none';
        featureThumb.style.display = 'block';
    });
}
imagesContainer.addEventListener('scroll', function(event){
    var element = event.target;
    if (element.scrollHeight - element.scrollTop === element.clientHeight){
        if(next_page_url !== null) {
            ajaxRequest('GET','',next_page_url,loadImages);
        }
    }
});

function resetChecked() {
    var checks = document.querySelectorAll('.dz-image-preview');
    if(checks.length) {
        for(let i = 0; i < checks.length; i++) {
            checks[i].setAttribute('aria-checked', false);
            checks[i].classList.remove('checked');
        }
    }
}

function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
function loadImages(res) {
    let results = JSON.parse(res);
    data = data.concat(results.result.data);
    next_page_url = results.result.next_page_url;
    renderImages();
}
function ajaxRequest(method,data,url,cb) {
    var http = new XMLHttpRequest;
    http.open(method,url,true);
    http.send(data);
    http.onreadystatechange = function(event) {
        if(http.readyState == 4 && http.status == 200) {
            cb(http.responseText);
        }
    }
}

function renderImages() { 
    var xhtml = '';
    if(data.length > 0) {
        var items = data.filter(onlyUnique);
        for(let i = 0; i < items.length; i++) {
            let item = items[i];
            xhtml +=` <div class="dz-image-preview" data-id="${item.id}" aria-checked="false" onclick="selectThumb(this)">
                        <div class="dz-image">
                            <img src="/images/${item.filename}" alt="">
                        </div>
                        <div class="dz-success-mark">
                            <span class="fa-stack fa-lg text-150"><i class="fa fa-circle fa-stack-2x text-white"></i><i class="fa fa-check fa-stack-1x fa-inverse text-success-m1"></i></span>
                        </div>
                    </div>`;
        }
        
    }
    imagesContainer.innerHTML = xhtml;
}
function selectThumb(that) {
    let id = that.getAttribute('data-id');
    let check = that.getAttribute('aria-checked');
    if(mode == 'post') {
        checkedMulti(that,check);
        let item = data.filter(element => element.id === parseInt(id));
        editItem = (!isEmpty(editItem) && editItem.id == item[0].id)? {}: editItem = item[0];
        selectedItem = checkItemExist(item[0])? selectedItem.filter(element => element.id !== item[0].id): [...selectedItem,item[0]];
    } else {
        resetChecked();
        checkedMulti(that,check);

        let item = data.filter(element => element.id === parseInt(id));
        editItem = (!isEmpty(editItem) && editItem.id == item[0].id)? {}: editItem = item[0];
        selectedItem = checkItemExist(item[0])? selectedItem.filter(element => element.id !== item[0].id): item;
    }

    showAttachmentDetail(that);
}
function checkedMulti(that,check) {
    if(check == 'false') {
        that.setAttribute('aria-checked', true)
        that.className += ' checked';
    } else if(check == 'true') {
        that.setAttribute('aria-checked', false)
        that.classList.remove('checked');
    }
}
function checkItemExist(item) {
    if(selectedItem.length == 0) return false;
    var res = selectedItem.filter(function(element) {
        return element.id == item.id;
    });
    if(res.length) return true;
    return false;
}
function showAttachmentDetail(that) {
    let check = that.getAttribute('aria-checked');
    let item = {};
    if(!isEmpty(editItem) && check == 'true') {
        item = editItem;
        
    } else if(selectedItem.length){
       item = selectedItem[selectedItem.length - 1];
    } else {
        item = '';
    }
    if(item !== '') {
        var xhtml = `<div class="media-info mb-4">
                    <h5>Attachment Detail
                        <span class="settings-save-status">
                            <span class="spinner"></span>
                            <span class="saved">Saved.</span>
                        </span>
                    </h5>
                    <div class="thumb">
                        <img src="/images/${item.filename}">
                    </div>
                    <div class="thumb-info">
                        <p id="file-name" class="text-sm pt-2 mb-0"><strong>${item.filename}</strong></p>
                        <p id="file-size" class="text-sm pt-2 mb-0">${item.filesize} KB</p>
                    </div>
                    <a href="javascript:;" id="item-del" data-id="${item.id}" class="text-md text-danger mb-2 mt-2 btn-block">Delete Permanently</a>
                </div>
                <div class="media-from">
                    <div class="form-group row">
                        <div class="col-3 col-form-label text-sm-right pr-0">
                            <label for="title">Title</label>
                        </div>
                        <div class="col-9">
                            <input type="text" data-field="title" data-id="${item.id}" name="title" value="${item.title}" class="form-control edit-form">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label text-sm-right pr-0">
                            <label for="caption">Caption</label>
                        </div>
                        <div class="col-9">
                            <textarea type="text" data-field="caption" data-id="${item.id}" name="caption" class="form-control edit-form">${item.caption == null ? '': item.caption }</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label text-sm-right pr-0">
                            <label for="alt">Alt</label>
                        </div>
                        <div class="col-9">
                            <input type="text" data-field="alt" data-id="${item.id}" name="alt" value="${item.alt == null ? '': item.alt}" class="form-control edit-form">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3 col-form-label text-sm-right pr-0">
                            <label for="description">Description</label>
                        </div>
                        <div class="col-9">
                            <textarea type="text" data-field="description" data-id="${item.id}" name="description" class="form-control edit-form">${item.description == null ? '': item.description }</textarea>
                        </div>
                    </div>
                </div>`;
    } else {
        var xhtml = '';
    }
    attachDetail.innerHTML = xhtml;
    editForm();
    deleteForm();
}

function editForm() {
    var edit = document.querySelectorAll('.edit-form');
    if(edit.length) {
        for(let i = 0; i < edit.length; i++) {
            edit[i].addEventListener('blur',function() {
                let filedValue = this.value;
                let field = this.getAttribute('data-field');
                let id = this.getAttribute('data-id');
                let url = attachDetail.getAttribute('data-edit');
                let token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

                let spinner = document.querySelector('.settings-save-status .spinner');
                let saved = document.querySelector('.settings-save-status .saved');
                
                if(filedValue.trim() == '') return;
                spinner.style.opacity = '0.7';
                var http = new XMLHttpRequest;
                var formData = new FormData();
                formData.append('id',parseInt(id));
                formData.append('field',field);
                formData.append('fieldValue',filedValue);
                formData.append('_token',token);
                http.open('POST',url,true);
                http.send(formData);
                http.onreadystatechange = function(event) {
                    if(http.readyState == 4 && http.status == 200) {
                        changeValue(id,field,filedValue);
                        spinner.style.opacity = 0;
                        saved.style.display = 'block';
                        setTimeout(function() {
                            saved.style.display = 'none';
                        },800);
                    }
                }
            })
        }
    }
}

function deleteForm() {
    var deleteF = document.getElementById('item-del');
    if(deleteF) {
        deleteF.addEventListener('click', function(){
            let token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
            let id = this.getAttribute('data-id');
            let url = attachDetail.getAttribute('data-del');
    
            var http = new XMLHttpRequest;
            var formData = new FormData();
            formData.append('id',parseInt(id));
            formData.append('_token',token);
    
            http.open('POST',url,true);
            http.send(formData);
            http.onreadystatechange = function(event) {
                if(http.readyState == 4 && http.status == 200) {
                    data = data.filter(item => item.id !== parseFloat(id));
                    renderImages();
                    attachDetail.innerHTML = '';
                }
            }
        });
    }
}
function findItem(id) {
    return selectedItem.findIndex(item => item.id == id);  
}
function isEmpty(obj) {
    return Object.keys(obj).length === 0;
}

function changeValue(id,field, newVal) {
    for( let i = 0; i < data.length; i++) {
        if(data[i].id == id) {
            data[i][field] = newVal;
            break;
        }
    }
}

document.getElementById('insert-img').addEventListener('click',function() {
    document.getElementById('close-modal').click();
    if(mode == 'post') {
        if(selectedItem.length) {
            for(let i = 0; i < selectedItem.length; i++) {
                let imageUrl = '/images/' + selectedItem[i].filename;
                $('#summernote').summernote('insertImage', imageUrl);
            }
        }
    } else if(mode == 'thumb') {
        if(selectedItem.length) {
            let imageUrl = '/images/' + selectedItem[0].filename;
            document.querySelector('.thumbnail img').src = imageUrl;
            document.querySelector('input[name=thumb]').value = selectedItem[0].filename;
            featureThumb.style.display = 'none';
            removeFeauture.style.display = 'block';
        }
    }
});

var changeAvatar = document.getElementById('change-avatar');
var avatar = document.getElementById('avatar');
if(changeAvatar) {
    changeAvatar.addEventListener('click',function(e) {
        e.preventDefault();
        if(avatar) {
            avatar.click();
        }
    })
}