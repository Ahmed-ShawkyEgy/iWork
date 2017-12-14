
    <form id="in">
        <input type="text">
    </form>
    <button onclick="fun()">+</button>
</body>


<script>
    var cntr = 0;

    function fun() {

        var form = document.getElementById("in");
        var div = document.createElement("div");
        div.className += " form-group";


        var child = document.createElement("input");
        child.setAttribute("name", "morgan" + cntr++);

        div.appendChild(child);
        form.appendChild(div);
    }

</script>

var submit = document.getElementById("button");
var form = document.getElementById("registerForm");
var div = document.createElement("div");
div.className += " form-group";
var child = document.createElement("input");
child.setAttribute("name", "addJob" + cntr++);
child.setAttribute("placeholder", "previous job");
child.setAttribute("style", "width: 400px;");
div.appendChild(child);
form.removeChild(submit);
form.appendChild(div);
form.appendChild(submit);






var submit = document.getElementById("button");
var form = document.getElementById("registerForm");
// var div = document.createElement("div");
// div.className += " form-group";
var child = document.createElement("input");
child.setAttribute("name", "addJob" + cntr++);
child.setAttribute("placeholder", "previous job");
child.setAttribute("style", "width: 400px;");
// div.appendChild(child);
form.removeChild(submit);
form.appendChild(child);
form.appendChild(submit);
