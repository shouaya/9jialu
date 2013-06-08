(function($) {
    $.dm = $.dm || {};
    $.extend($.dm, {
		_map: null,
		_service: null,
		init: function(id, point, zoom, markerArr, searchback){
			this.createMap(id, point, zoom, markerArr);
			this.setMapEvent(searchback);
			this.addMapControl();
		},
		createMap: function(id, point, zoom, markerArr){
			this._map = new BMap.Map(id);
			this._map.centerAndZoom(point, zoom);
			this.addMarker(markerArr);
		},
		setMapEvent: function(searchback){
			this._service = new BMap.LocalSearch(this._map);
			this._service.setSearchCompleteCallback(function(results){
				var pois = results._pois;
				searchback(pois);
			});
			this._map.enableDragging();
			this._map.enableScrollWheelZoom();
			this._map.enableDoubleClickZoom();
		},
		addMapControl: function(){
			var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_LARGE});
			this._map.addControl(ctrl_nav);
		},
		addMarker: function(markerArr){
			for(var i=0;i<markerArr.length;i++){
				var json = markerArr[i];
				var p0 = json.point.split("|")[0];
				var p1 = json.point.split("|")[1];
				var point = new BMap.Point(p0,p1);
				var iconImg = this.createIcon(json.icon);
				var marker = new BMap.Marker(point,{icon:iconImg});
				var iw = this.createInfoWindow(i, markerArr);
				var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
				marker.setLabel(label);
				this._map.addOverlay(marker);
				label.setStyle({
							borderColor:"#808080",
							color:"#333",
							cursor:"pointer"
				});
				
				(function(){
					var index = i;
					var _iw = $.dm.createInfoWindow(i, markerArr);
					var _marker = marker;
					_marker.addEventListener("click",function(){
						this.openInfoWindow(_iw);
					});
					_iw.addEventListener("open",function(){
						_marker.getLabel().hide();
					})
					_iw.addEventListener("close",function(){
						_marker.getLabel().show();
					})
					label.addEventListener("click",function(){
						_marker.openInfoWindow(_iw);
					})
					if(!!json.isOpen){
						label.hide();
						_marker.openInfoWindow(_iw);
					}
				})()
			}
		},
		createInfoWindow: function(i, markerArr){
			var json = markerArr[i];
			var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
			return iw;
		},
		createIcon: function(json){
			var icon = new BMap.Icon("http://map.baidu.com/image/us_cursor.gif", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
			return icon;
		}

	});
})(jQuery);