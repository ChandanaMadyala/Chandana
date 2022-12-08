document.write(`

<div class="Standalone">
<button onclick="StandaloneLoader()" type="button">Standalone</button>
</div>
<script>

function StandaloneLoader(){
var window3d = window.open("./index.php", '_blank', 'location=no,status=no,scrollbars=yes,resizable=yes,width=screen.width * 0.8,height=screen.height * 0.8');
//var window3d = window.open("./Simple_Chair_Inscene.php", 'location=no,status=no,scrollbars=yes,resizable=yes,width=screen.width * 0.8,height=screen.height * 0.8');
window3d.resizeTo(screen.width* 0.8, screen.height * 0.8);
window3d.moveTo(screen.width* 0.1 * Math.random(), screen.height * 0.1 * Math.random());
window3d.focus()
};
</script>`)