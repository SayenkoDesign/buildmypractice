(function (document, window, $) {

	'use strict';
    
    // https://whoisxmlapi.github.io/domain-availability
    
    var domain = "kylerumble.com";
    
    var password = "Aq11..Sw22";
    var username = "kylerumble";
    
    // https://www.whoisxmlapi.com/whoisserver/WhoisService?cmd=GET_DN_AVAILABILITY&domainName=test.com&username=xxxxx&password=xxxxx&getMode=DNS_AND_WHOIS
/*
    $(function () {
        $.ajax({
            url: "//www.whoisxmlapi.com/whoisserver/WhoisService",
            dataType: "jsonp",
            crossDomain: true,
            data: {domainName: domain, username: username,
                   password: password, outputFormat: "JSON",
                   cmd: "GET_DN_AVAILABILITY"},
            success: function(data) {
                $("#primary").append("<pre>"+ JSON.stringify(data,"",2)+"</pre>");
            },
            error: function (jqXHR, text, errorThrown) {
                  console.log(jqXHR + " " + text + " " + errorThrown);
              }
        });
    });
    
    /*
    
    var key = "401df6bc-5f90-4981-b3ff-dc2b6d7580bd";
    var secret = "MIIBVAIBADANBgkqhkiG9w0BAQEFAASCAT4wggE6AgEAAkEAxBJu2jV6cL/LLTwaGdyy2SQu9srJKYsvnG5fWQGyNZbZexCAOZcLAYt0xuRngG1cV2+pKoGYXY4P457PXySZ2wIDAQABAkEArMyKAamr9P4y8/TKFAzbWl93PG1PiFtwZG8pfOnvwyVY6VUAgHa+ey5GRM35xov0bNTpAGATlyX/SY+lRHw0YQIhAPLhB3g1XtcNZFLE/Qr6brdKMtXZVRpNEkbFvHBlT4ojAiEAzqoSWUWCrcwwIgCt6po71SN2yqjZOALXwO2GHRyOoOkCIA/dhThj/Br+I/SIK6Ng8oSEk0eG19lM+Ymn9wQ8ifKTAiBAmO51UwHe21UsO7QhAaa0H4qxHAgRtunDlzr1fIikiQIgXe+f2qdcvjrMaPHfivSiJiKc7nZhmetg5PUQQ9nOCaM=";
    var username = "kylerumble";

    $(function () {
        var time = (new Date()).getTime();
        var req = btoa(unescape(
                    encodeURIComponent(JSON.stringify({t:time,u:username}))));
        var digest = CryptoJS.HmacMD5(
                        username+time+key,secret).toString(CryptoJS.enc.Hex);
        $.ajax({
            url: "//www.whoisxmlapi.com/whoisserver/WhoisService",
            dataType: "jsonp",
            data: {requestObject:req, digest:digest, cmd:"GET_DN_AVAILABILITY",
                   domainName: domain, outputFormat: "JSON"},
            success: function(data) {
                $(".domain-search").append("<pre>"+ JSON.stringify(data,"",2)+"</pre>");
            }
        });
    });
    
    */
    
}(document, window, jQuery));


