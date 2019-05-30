<html>

<head>
    <script src="jquery-3.0.0.min.js"></script>
    <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
    <style>
      .message {
        background-color: #222;
        border: 1px solid #dcdcdc;
        color: #fff;
        font-family: tahoma;
        margin-top: 84px;
        min-height: 250px;
        padding: 2px 45px;
        text-align: left;
        width: 50%;
        word-wrap: break-word;
      }
    </style>
</head>
<body>
    <div>
      <center>
        <h3>View the video demo in youtube <a href="https://youtu.be/o2-PCiiJzr4" target="_blank">https://youtu.be/o2-PCiiJzr4</a></h3>
        <br>
        <input value="+84" id="country_code" />
        <input placeholder="phone number" id="phone_number" />
        <button onclick="smsLogin();">Login via SMS</button>
        <div>OR</div>
        <input placeholder="email" id="email" />
        <button onclick="emailLogin();">Login via Email</button>
        <div class="message">
            <center><b>Message Board</b></center>
            <p>initialized Account Kit.</p>
            <p>Đọc thêm tại: <a href="https://kipalog.com/posts/Account-Kit--Su-dung-tool-password-p2"></a></p>
        </div>
      </center>
    </div>
    <script>
      // initialize Account Kit with CSRF protection
      // Khởi tạo Account Kit và thiết lập trình xử lý JavaScript cho lệnh gọi lại đăng nhập
      AccountKit_OnInteractive = function(){
        AccountKit.init(
          {
            appId:"1631807450445260", // ID ỨNG DỤNG: 1631807450445260 của Hà Nội Phố
            state:"CSRF_TOKEN", // Tự đặt, đặt càng dài bảo mật càng tốt
            version:"v1.0",
            fbAppEventsEnabled:true
          }
        );
      };
      // login callback
      function loginCallback(response) {
        if (response.status === "PARTIALLY_AUTHENTICATED") {
          var code = response.code;
          var csrf = response.state;
            $(".message").append("<p>Received auth token from facebook -  "+ code +".</p>");
            // $(".message").append("<p>Đã nhận được mã thông báo xác thực từ facebook -  "+ code +".</p>");
            $(".message").append("<p>Triggering AJAX for server-side validation.</p>");
            // $(".message").append("<p>Kích hoạt AJAX để xác thực phía máy chủ.</p>");
            $.post("verify.php", { code : code, csrf : csrf }, function(result){
                $(".message").append( "<p>Server response : " + result + "</p>" );
                // $(".message").append( "<p>Phản hồi của máy chủ : " + result + "</p>" );
            });
            
        }
        else if (response.status === "NOT_AUTHENTICATED") {
          // handle authentication failure
            $(".message").append("<p>( Error ) NOT_AUTHENTICATED status received from facebook, something went wrong.</p>");
            // $(".message").append("<p>( Lỗi ) không ủy quyền trạng thái nhận được từ facebook, một cái gì đó đã sai.</p>");
        }
        else if (response.status === "BAD_PARAMS") {
          // handle bad parameters
            $(".message").append("<p>( Error ) BAD_PARAMS status received from facebook, something went wrong.</p>");
            // $(".message").append("<p>( Lỗi ) BAD_PARAMS trạng thái nhận được từ facebook, một cái gì đó đã sai.</p>");
        }
      }
      // phone form submission handler
      function smsLogin() {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        $(".message").append("<p>Triggering phone validation.</p>");
        // $(".message").append("<p>Xác nhận điện thoại kích hoạt.</p>");
        AccountKit.login(
          'PHONE', 
          {countryCode: countryCode, phoneNumber: phoneNumber}, 
          // will use default values if not specified 
          //sẽ sử dụng các giá trị mặc định nếu không được chỉ định
          loginCallback
        );
      }
      // email form submission handler
      function emailLogin() {
        var emailAddress = document.getElementById("email").value;
        AccountKit.login(
          'EMAIL',
          {emailAddress: emailAddress},
          loginCallback
        );
      }
    </script>
    <p>Đây là kết quả xác thực bằng Phone</p>
    <pre>
      + initialized Account Kit.
      + Triggering phone validation.
      +  Received auth token from facebook - AQCQdGi7cGgTgYVVzpIQUhqmycoGlpeb9H_e1FK6qGRKLy-oPKkDl7R6nUms8ybb6oCrFc7279ETOkvLocbrV4dwmYVYmlvVKD8gxaHeAvhddxrtwfQkdSgsG-wiqgnsMj6vnrVe9C6r3Uwhib3EefQpi8dvocpijKy5IZJ-u16Vtb4A8ctjEiAPDUhWfqgJZ35ixtGMC2L6aJy3REHuWDSzWIK3OxM3zQYYCYAMTNlO3xlFmLdRaLjaIch2oDV8KlT1TQEiVOaINKeLVyHPfIhH.
      + Triggering AJAX for server-side validation.
      + Server response : {"id":"763871567348236","phone":{"number":"+84869998187","country_prefix":"84","national_number":"869998187"},"application":{"id":"1631807450445260"}}
    </pre>
    <p>Đây là kết quả xác thực bằng Email</p>
    <pre>
      + initialized Account Kit.
      + Received auth token from facebook - AQCm51lJ43G6FojulGhIe6wyuQD-X9Gb2dPrnJefpOYTVIr_8P5h3PNadaT-2PAv8RxHBQjWP5CE1m5hGkUAkkl7te7rIQvCHLNUBIulU3VAt4vU7SmFuWmab-DEvwIznOYWtndzHf6GDQv8twa3woyy_vl53wVDvgqB6BE0LrUP6TxMlVOM7Y1acvPo2gP-5EUa-Tr4eV4Qoq5CZL1j_gUCjOM_Ul7ak7QBq0DQ0GVFEwX0DMg4YZdteB1pt8yDh5esuivb7yoFI3PRmSTPOyLi.
      + Triggering AJAX for server-side validation.
      + Server response :
    </pre>
</body>
</html>