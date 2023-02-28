<!doctype html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Waterdeep Interactive&nbsp;Map</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="Waterdeep Interactive&nbsp;Map : We have zoom, distance calculator, display of area/regions, marks selection, and more !">	<script src="../dnd-commun/lib/jquery.min.js"></script>
	<script src="https://www.aidedd.org/dnd-commun/lib/jquery-ui.min.js"></script>
	<script src="https://www.aidedd.org/dnd-commun/lib/raphael.min.js"></script>
	<script src="https://www.aidedd.org/atlas/lang_1.js?v=2"></script>
	<script src="https://www.aidedd.org/atlas/fonctions.js?v=9"></script>
	<link rel="canonical" href="https://www.aidedd.org/atlas/index.php?map=W&l=1">
	<link rel="icon" href="../images/favicon.ico" sizes="16x16">
	<link rel="icon" href="../images/favicon-32x32.png" sizes="32x32">
	<link rel="apple-touch-icon" href="../images/favicon-152x152.png" sizes="152x152">
	<link rel="icon" href="../images/favicon-192x192.png" sizes="192x192">
	<link rel="stylesheet" href="https://www.aidedd.org/css/all.min.css">
	<link rel="stylesheet" href="https://www.aidedd.org/atlas/style.css?v=2" type="text/css"> 
<script src='https://www.aidedd.org/atlas/dataW.js?v=0'></script>	<!-- Google Analytics -->
	<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-3N5TZKQ532"></script> -->
	<!-- <script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'G-3N5TZKQ532', {'content_group':'Atlas'});
	</script> -->
</head>

<body>
	<script>
		var carte = 'W';
		var lang  = '1';

		if (isMobile())
		{	moveStep=100, zoomMax=zoomCelMax; }
		else
		{	moveStep=100; }

		var screenW = $(window).width();
 		var screenH = $(window).height();
		var zoom=1, zoomLite=1.1, zoomStrong=1.6;
		var arr = new Array();
		var IdRaphael = new Array();
		var availableLieux = new Array();
		var viewPoints=0, viewZones=1; 
		var Xclick=Yclick=oldX=oldY=0;
		var clickToMove=drawing=0, distance, idT;
		var offsetXU=offsetYU=0;	
		var multipleSearch=0;

		$("body").css("overflow", "hidden"); 	/* enleve les scrollbar */
	</script>
	<div id="bandeau">
		<i class="fas fa-bars" title="Menu" onclick="toggleMenu()"></i>
		<div class="filtre"><i id="del-icon" class="fas fa-times" style="display:none" title="Clear" onclick="setSearch()"></i><i id="search-icon" class="fas fa-search"></i><i id="exch-icon" class="fas fa-exchange-alt" style="display:none" title="Select a second point" onclick="MultipleSearch()"></i><input id="search" value="Search" class="txtgris" onclick="clearSearch()"></div>
	</div>
	<div id="descr"><div id="txt"><h1>Mapa Interactivo &nbsp;Waterdeep</h1></div><div id="unset" onclick="unshowDescr()"><i class="fas fa-chevron-up"></i></div></div>
	<div id="menu" style="display:none">
			<button class='subMenu' onclick="setPoints(1)"><i class="fas fa-map-marker-alt"></i> Show/Hide all Marks Ctrl+A</button>
			<button class='subMenu noCel' onclick="trajet(1)"><i class="fas fa-arrows-alt-h"></i> Distance and Time Ctrl+D</button><hr>
			<button class='subMenu' onclick="location.href='./index.php?map=R&l=1'"><i class="fas fa-map"></i> Forgotten Realms Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=W&l=1'"><i class="fas fa-map"></i> Waterdeep Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=N&l=1'"><i class="fas fa-map"></i> Neverwinter Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=B&l=1'"><i class="fas fa-map"></i> Baldur's Gate Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=I&l=1'"><i class="fas fa-map"></i> Icewind Dale Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=M&l=1'"><i class="fas fa-map" style="color:#B80000"></i> Menzoberranzan Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=P&l=1'"><i class="fas fa-map"></i> Laelith Provinces Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=L&l=1'"><i class="fas fa-map"></i> Laelith Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=K&l=1'"><i class="fas fa-map"></i> Kara-Tur Map</button>
			<button class='subMenu' onclick="location.href='./index.php?map=G&l=1'"><i class="fas fa-map"></i> Greyhawk Map</button>
			<hr>
			<!-- button class='subMenu noCel' onclick="window.open('submit.php?map=W')"><i class="fas fa-bookmark"></i> Modify/Add a Mark</button -->
			<button class='subMenu noCel' onclick="window.open('https://www.aidedd.org/en/contact/')"><i class="fas fa-pencil-alt"></i> Send a Comment</button>
			<button class='subMenu' onclick="test()"><i class="fas fa-info"></i> Information</button>
	</div>
	<div id="map"></div>

	<i id="zoomP" class="fas fa-plus icon bZoomP"  title="Zoom" onclick="setZoom(zoomStrong)"></i>
	<i id="zoomM" class="fas fa-minus icon bZoomM" title="Zoom" onclick="setZoom(-zoomStrong)"></i>
	<i class="fas fa-map-marker-alt icon bPoints" title="Select Details" onclick="$('#points').toggle();"></i>
	<button id="bZone" class="bZone bZoneV" title="Show/Hide Areas" onclick="toogleZones()"></button>
	<div id="points" style="display:none"></div>

	<script>
 		var map = new Raphael("map", imageW, imageH);	
		map.setSize('100%', '100%');

		if (isMobile())
		{
			$('#map').css("background-image", "url('images/"+imageMob+"')");
			$('#txt').append('<p>Get more <strong>informations</strong> by tapping an area or a mark on the map, or enter a name.</p><p><strong>Zoom</strong> by using the buttons on the map or with pinch gestures.</p><p><strong>Move</strong> the map by draging it.</p>');
		}
		else
		{
			$('#map').css("background-image", "url('images/"+image+"')");
			$('#txt').append('<p>Get more <strong>informations</strong> by clicking an area or a mark on the map, or enter a name.</p><p><strong>Zoom</strong> by using the buttons on the map, your mouse wheel or the \'+\' and \'-\' keys on your keyboard.</p><p><strong>Move</strong> the map by draging it with your mouse or using your keyboard arrows.</p><p><strong>Calculate a distance</strong> by selecting the corresponding option in the menu.</p>');
		}
		$('#txt').append('<p><em>Map by ' + auteur + '</em>.</p><br><p class="center"><a href="./index.php?map=W&l=0">VERSION FRANÇAISE</a></p><br><a href=\"https://www.buymeacoffee.com/aidedd\"><img src=\"images/coffee.svg\" class=\"coffee\" width=\"150\" title=\"Buy Me a Coffee\" alt=\"Coffee\"></a>');
		$('#txt').append('<br><p class=\"center\" style="font-size:1.8rem; color:#B80000"><i class="fas fa-info-circle"></i> <strong>New Map Available</strong></p>');
		$('#bZone').css("background-image", "url('images/"+mini+"')");

		var g=1;
		$.each(groupe, function (i, item) {

			if (bilang)
			{
				if (lang == 0)
				{
					if (typeof item.name0 !== 'undefined')
					{ nameP = item.name0; nameS = item.name1; text = item.txt0;}
					else
					{ nameP = nameS = item.name1; text = item.txt1;}					
				}
				else if (lang == 1)
				{
					if (typeof item.name1 !== 'undefined')
					{ nameP = nameS = item.name1; text = item.txt1;}
					else
					{ nameP = nameS = item.name0; text = item.txt0;}					
				}
			}
			else
			{
				nameP = nameS = item.name; text = item.txt;
			}

			if (nameP == "GROUP")
			{
				$('#points').append("<input type='checkbox' id='ptv"+g+"' value='1' style='border-color:"+item.color+"' checked='checked' onchange='setPoints(2);'><div class='legend' style='background-color:"+item.color+"'> </div> "+text+"<br>");
				g++;
			}
			else
			{
				availableLieux.push(nameP);
				if (nameP != nameS) availableLieux.push(nameS);
			}
		});

		setZoom(0);

		/* trace des zones */

		var dot;
		var	line;
 		var style = {fill:"white", "fill-opacity":.5, "stroke-width":0,	"stroke-linejoin":"round"};
		for (var regionIndex in zones) {
			var obj = map.path(zones[regionIndex].path);
			obj.node.id = "zone"+regionIndex;
			IdRaphael["zone"+regionIndex] = obj.id;
			arr[obj.id] = regionIndex;
			obj.attr(style);
			if  (typeof(zones[arr[obj.id]].bord) !== 'undefined')
				obj.attr({'stroke-dasharray':'- '});
 			obj.attr({fill: zones[arr[obj.id]].couleur});

			obj.click(function() {
				if (viewZones == 1)
				{
					if (bilang)
					{
						if (lang == 0)
						{
							if (typeof zones[arr[this.id]].name0 !== 'undefined')
							{ nameP = zones[arr[this.id]].name0; nameS = zones[arr[this.id]].name1;}
							else
							{ nameP = nameS = zones[arr[this.id]].name1;}	
													
							if (typeof zones[arr[this.id]].txt0 !== 'undefined')
							{ text = zones[arr[this.id]].txt0;}
							else
							{ text = zones[arr[this.id]].txt1;}							
						}
						else if (lang == 1)
						{	
							if (typeof zones[arr[this.id]].name1 !== 'undefined')
							{ nameP = nameS = zones[arr[this.id]].name1;}
							else
							{ nameP = nameS = zones[arr[this.id]].name0;}	
													
							if (typeof zones[arr[this.id]].txt1 !== 'undefined')
							{ text = zones[arr[this.id]].txt1;}
							else
							{ text = "";}							
						}
					}
					else
					{
						nameP = nameS = zones[arr[this.id]].name; 
						text = zones[arr[this.id]].txt;
					}

					var descr = "<h2>"+nameP+"</h2>";
					if (nameP != nameS) descr += "<h3>[ "+nameS+" ]</h3>";
					descr += text;
		
					$('#txt').html(descr);
					showDescr();
				}
			});

			obj.mouseover (function() {
				if (viewZones == 1)
				{
					var thisNodeId = this.node.id;

					$("[id^='zone']").each(function() {
						if ($(this).attr("id") != thisNodeId)
							map.getById(IdRaphael[$(this).attr("id")]).toBack();
					});

					this.attr({'stroke-width': lineFocus});
				}
			});

		 	obj.mouseout (function() {
				if (viewZones == 1) 
				{
					this.attr({'stroke-width': 0})
				}
			});
		}

		toogleZones();
		setPoints(0);

	$('#map').on('mousedown touchstart', function(e) {
		e = e.originalEvent;

		if (typeof (e.touches) !== 'undefined' && e.touches.length == 2)
		{
			oldX = Math.abs(e.touches[0].pageX - e.touches[1].pageX);
			oldY = Math.abs(e.touches[0].pageY - e.touches[1].pageY);
		}
		else
		{
			if	(e.type == 'touchstart')
			{
				var Xclick = e.touches[0].pageX;
				var Yclick = e.touches[0].pageY;
			}
			else
			{
				var Xclick = e.pageX;
				var Yclick = e.pageY;
			}

			if (drawing == 1)
			{
				oldX = parseInt((Xclick + (imageW*zoom - screenW)/2)/zoom + offsetXU);
				oldY = parseInt((Yclick + (imageH*zoom - screenH)/2)/zoom + offsetYU);

				$('#txt').html(LgNextTra);
				showDescr();
				distance = 0;
				drawing = 2;
				idT = 0;
			}
			else if (drawing == 2)
			{
				drawLine(parseInt((Xclick + (imageW*zoom - screenW)/2)/zoom + offsetXU), parseInt((Yclick + (imageH*zoom - screenH)/2)/zoom + offsetYU));
			}	
			else
			{
				clickToMove = 1;
				oldX = Xclick;
				oldY = Yclick;
			}
		}
	});

	$('#map').on('mousemove touchmove', function(e) {
		e = e.originalEvent;
		if (typeof (e.touches) !== 'undefined' && e.touches.length == 2)
		{
			Xclick = Math.abs(e.touches[0].pageX - e.touches[1].pageX);
			Yclick = Math.abs(e.touches[0].pageY - e.touches[1].pageY);

			var sensX = Xclick - oldX;
			var sensY = Yclick - oldY;
			if (sensX > 10 || sensY > 10)
			{
				setZoom(zoomLite);
				oldX = Xclick;
				oldY = Yclick;
			}
			else if (sensX < -10 || sensY < -10)
			{
				setZoom(-zoomLite);
				oldX = Xclick;
				oldY = Yclick;
			}
		}
		else
		{
			if	(e.type == 'touchmove')
			{
				var Xclick = e.touches[0].pageX;
				var Yclick = e.touches[0].pageY;
			}
			else
			{
				var Xclick = e.pageX;
				var Yclick = e.pageY;
			}

			if (clickToMove) 
			{
				offsetXU = offsetXU + (oldX - Xclick)/zoom;
				offsetYU = offsetYU + (oldY - Yclick)/zoom;
				moveMap();
				oldX = Xclick;
				oldY = Yclick;
			}
		}
	});

	$('#map').on('mouseup touchend', function() {
		clickToMove = 0;
	});
	$('#descr').on('mouseup touchend', function() {
		if (clickToMove) 
			window.getSelection().empty();
		clickToMove = 0;
	});

	window.addEventListener('resize', function () { 
   		if (!isMobile())
			window.location.reload(); 
	});
	</script>
</body>
</html>