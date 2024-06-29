let feature_s_form = document.getElementById("feature_s_form");
let facility_s_form = document.getElementById("facility_s_form");

feature_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_feature();
});

function add_feature() {
  let data = new FormData();
  data.append("name", feature_s_form.elements["feature_name"].value);
  data.append("add_feature", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("feature-s");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide(); //tat modal khi submit

    if (this.responseText == 1) {
      alert("success", "Tính Năng đã Thêm Mới!");
      feature_s_form.elements["feature_name"].value = "";
      get_features();
    } else {
      alert("error", "Server Down!");
    }
  };
  xhr.send(data);
}
//
function get_features() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("features-data").innerHTML = this.responseText;
  };
  xhr.send("get_features");
}
//
function rem_feature(val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Tính Năng đã Xóa!");
      get_features();
    } else if ((this.responseText = 3)) {
      //room_added
      alert("error", "Tính Năng Tồn Tại ở Phòng Nào đó! Không Thể Xóa.");
    } else {
      alert("error", "Server down!");
    }
  };
  xhr.send("rem_feature=" + val);
}
// facility

facility_s_form.addEventListener("submit", function (e) {
  e.preventDefault();
  add_facility();
});

function add_facility() {
  let data = new FormData();
  data.append("name", facility_s_form.elements["facility_name"].value);
  data.append("icon", facility_s_form.elements["facility_icon"].files[0]);
  data.append("desc", facility_s_form.elements["facility_desc"].value);
  data.append("add_facility", "");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);

  xhr.onload = function () {
    var myModal = document.getElementById("facility-s");
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == "inv_img") {
      alert("error", "Chỉ nhận file SVG!");
    } else if (this.responseText == "inv_size") {
      alert("error", "Ảnh phải đảm bảo < 1MB!!");
    } else if (this.responseText == "upd_failed") {
      alert("error", "Tải Ảnh Thất Bại. Server shutdown!");
    } else {
      alert("success", "Tiện Ích Mới đã Thêm!");
      facility_s_form.reset();
      get_facilities();
    }
  };
  xhr.send(data);
}

function get_facilities() {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    document.getElementById("facilities-data").innerHTML = this.responseText;
  };
  xhr.send("get_facilities");
}

function rem_facility(val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/features_facilities.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (this.responseText == 1) {
      alert("success", "Tiện Ích đã Xóa!");
      get_facilities();
    } else if ((this.responseText = 3)) {
      //room_added
      alert("error", "Tiện Ích Tồn Tại ở Phòng Nào đó! Không Thể Xóa.");
    } else {
      alert("error", "Server down!");
    }
  };
  xhr.send("rem_facility=" + val);
}

window.onload = function () {
  get_features();
  get_facilities();
};

{
  /* 
         * function func1() { 
         get_features();
        }
        
        function func2() { 
        get_facilities();
        }
        
        function addLoadEvent(func) { 
        var oldonload = window.onload; 
        if (typeof window.onload != 'function') { 
            window.onload = func; 
        } else { 
            window.onload = function() { 
            if (oldonload) { 
                oldonload(); 
            } 
            func(); 
            } 
        } 
        }
        
        addLoadEvent(func1); 
        addLoadEvent(func2); 
        addLoadEvent(function() { 
                document.body.style.backgroundColor = '#EFDF95'; 
        })  */
}
