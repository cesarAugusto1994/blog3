(function(b){b.fn.transpose=function(q){var d=b.extend({},b.fn.transpose.defaults,q);var o=null;var p
    =[{name:"Ab",value:0,type:"F"},{name:"A",value:1,type:"N"},{name:"A#",value:2,type:"S"},{name:"Bb",value
    :2,type:"F"},{name:"B",value:3,type:"N"},{name:"C",value:4,type:"N"},{name:"C#",value:5,type:"S"},{name
    :"Db",value:5,type:"F"},{name:"D",value:6,type:"N"},{name:"D#",value:7,type:"S"},{name:"Eb",value:7,type
    :"F"},{name:"E",value:8,type:"N"},{name:"F",value:9,type:"N"},{name:"F#",value:10,type:"S"},{name:"Gb"
    ,value:10,type:"F"},{name:"G",value:11,type:"N"},{name:"G#",value:0,type:"S"}];var j=function(r){if(r
        .charAt(r.length-1)=="m"){r=r.substring(0,r.length-1)}for(var s=0;s<p.length;s++){if(r==p[s].name){return
    p[s]}}};var i=function(r){if(r.length>1&&(r.charAt(1)=="b"||r.charAt(1)=="#")){return r.substr(0,2)
}else{return r.substr(0,1)}};var k=function(u,v,r){var t=j(u).value+v;if(t>11){t-=12}else{if(t<0){t+
    =12}}var s=0;if(t===0||t===2||t===5||t===7||t===10){switch(r.name){case"A":case"A#":case"B":case"C":case"C
#":case"D":case"D#":case"E":case"F#":case"G":case"G#":for(;s<p.length;s++){if(p[s].value==t&&p[s].type
    =="S"){return p[s]}}break;default:for(;s<p.length;s++){if(p[s].value==t&&p[s].type=="F"){return p[s]
}}}}else{for(;s<p.length;s++){if(p[s].value==t){return p[s]}}}};var h=function(r){switch(r.charAt(r.length-1
)){case"b":return"F";case"#":return"S";default:return"N"}};var m=function(s,r){if(s>r){return 0-(s-r
    )}else{if(s<r){return 0+(r-s)}else{return 0}}};var g=function(s,r){var t=j(r);if(o.name==t.name){return
}var u=m(o.value,t.value);b("span.chord",s).each(function(v,w){n(w,u,t)});o=t};var n=function(u,z,r)
{var s=b(u);var w=s.text();var A=i(w);var y=k(A,z,r);var x=y.name+w.substr(A.length);s.text(x);var t
    =s[0].nextSibling;if(t&&t.nodeType==3&&t.nodeValue.length>0&&t.nodeValue.charAt(0)!="/"){var v=l(w.length
    ,x.length,t.nodeValue.length);t.nodeValue=e(" ",v)}};var l=function(s,r,t){if(s>r){return(t+(s-r))}else
{if(s<r){return(t-(r-s))}else{return t}}};var e=function(t,u){var v=[];for(var r=0;r<u;r++){v.push(t
)}return v.join("")};var c=function(s){if(s.trim()===""){return false}if(s.indexOf("|")!=-1){return false
}var u=s.replace(/[\,]/g,"").replace(/\s+/," ").split(" ");var v=0;var r=0;for(var t=0;t<u.length;t+
+){if(!b.trim(u[t]).length==0&&!u[t].match(d.chordRegex)){r+=1}else{v+=1}}return v>r?true:false};var
    f=function(r){return r.replace(d.chordReplaceRegex,"<span class='chord'>$1</span>")};
return b(this).each(function(){var x=b(this).attr("data-key");if(!x||b.trim(x)===""){x=d.key}if(!x||b.trim(x)===""
    ){throw ("Starting key not defined.")}o=j(x);b(".transpose-keys a").each(function(z,y){if(o.name==y.text
    ){b(this).parent().addClass("active")}});var w=b(this);b(".transpose-keys a").click(function(y){y.preventDefault
    ();g(w,b(this).text());b(".transpose-keys a").parent().removeClass("active");b(this).parent().addClass
    ("active");return false});var t=[];var s=b(this).text().split("\n");var r,v="";for(var u=0;u<s.length
        ;u++){r=s[u];if(c(r)){t.push("<span>"+f(r)+"</span>")}else{r=r.replace(/\|/g,'<span class="pipe">|</span >');t.push("<span>"+r+"</span>")}}b(this).html(t.join("\n"))})};var a="[A-G][\\#|b]{0,1}(m7\\(4\\)|m7\\+|m6|m7|m9|mº|m5\\+|m\\(7M\\)|m|dim|sus|sus4|2|4|5|6|7\\(b13\\)|7\\(b9\\)|7\\+\\/9|\\(\\#5\\)|7sus
        |7\\(4\\)|7\\/4|7\\(9\\)|7\\(11\\)|7M|7|9|\\º|\\º7|\\(5\\#\\)){0,1}[\\/]{0,1}";b.fn.transpose.defaults
            ={chordRegex:new RegExp("^"+a+"([A-G][b\\#]{0,1}){0,1}$"),chordReplaceRegex:new RegExp("("+a+")","g"
        )}})(jQuery);