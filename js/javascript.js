var webglAvail = false;

if(Detector.webgl){
// if (false){
	init();
	webglAvail = true;
}
else{
	document.getElementById("arwing").innerHTML += "<div></div>";
}

var container, stats;

var camera, scene, renderer;

var mouseX = 0, mouseY = 0;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;

animate();

function init() {

	container = document.createElement( 'div' );
	document.body.appendChild( container );

	camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
	// camera.position.z = 100;
	camera.position.x = 3000;
	camera.position.z = 100;
	camera.position.y = 1000;

	// scene

	scene = new THREE.Scene();

	var ambient = new THREE.AmbientLight( 0x101030 );
	scene.add( ambient );

	var directionalLight = new THREE.DirectionalLight( 0xffeedd );
	directionalLight.position.set( 0, 0, 1 ).normalize();
	scene.add( directionalLight );

	// texture

	var texture = new THREE.Texture();

	var loader = new THREE.ImageLoader();
	loader.addEventListener( 'load', function ( event ) {

		texture.image = event.content;
		texture.needsUpdate = true;

	} );
	// loader.load( 'js/models/arwing_03.png' );
	loader.load( 'js/models/arwing_01.png' );

	// model

	var loader = new THREE.OBJLoader();
	loader.addEventListener( 'load', function ( event ) {

		var object = event.content;

		object.traverse( function ( child ) {

			if ( child instanceof THREE.Mesh ) {

				child.material.map = texture;

			}

		} );

		// object.material.map = texture;

		object.doubleSided = true;
		object.position.y = -10;
		object.scale.set(1.7,1.7,1.7);
		scene.add( object );

	});
	loader.load( 'js/models/arwing.obj' );

	scene.position.y = -10;

	// if ( Detector.webgl ){
		 renderer = new THREE.WebGLRenderer();
	// }
	// else{
	// 	 renderer = new THREE.CanvasRenderer();
	// }
	//renderer = new THREE.WebGLRenderer();
	renderer.setSize( window.innerWidth, window.innerHeight );
	container.appendChild( renderer.domElement );

	document.addEventListener( 'mousemove', onDocumentMouseMove, false );

	//

	window.addEventListener( 'resize', onWindowResize, false );
}

function onWindowResize() {

	windowHalfX = window.innerWidth / 2;
	windowHalfY = window.innerHeight / 2;

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize( window.innerWidth, window.innerHeight );

}

function onDocumentMouseMove( event ) {

	mouseX = ( event.clientX - windowHalfX ) / 10;
	mouseY = ( event.clientY - windowHalfY ) / 10;

}

//

function animate() {
	if(webglAvail){
		requestAnimationFrame( animate );
		render();
	}
}

function render() {

	camera.position.x += ( mouseX - camera.position.x ) * .05 + 7;
	camera.position.y += ( - mouseY - camera.position.y ) * .05 + 2;

	camera.lookAt( scene.position );

	renderer.render( scene, camera );

}

function showPopup(_element){
	$("#"+_element).fadeIn(1000);
}

function hidePopup(_element){
	$("#"+_element).fadeOut(1000);
}