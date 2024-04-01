var els = ["zayav", "zayav_str2", "svidoroj", "pasport_str1", "pasport_str2", "napravlenie", "vipiska_str1", "vipiska_str2", "harkt_str1", "harkt_str2", "harkt_str3", "harkt_str4", "harkt_str5", "konsil_str1", "konsil_str2", "konsil_str3", "zaklpredpmpk_str1", "zaklpredpmpk_str2", "mse_str1", "mse_str2"];
var el;
for (let i = 0; i < els.length; i++) {
  el = els[i];
  document.getElementById(el).addEventListener('change', function (e) {
    const that = e.target;
    var fReader = new FileReader();
    fReader.readAsDataURL(that.files[0]);
    fReader.onloadend = function (event) {
      that.nextElementSibling.src = event.target.result;
    }
  });
}