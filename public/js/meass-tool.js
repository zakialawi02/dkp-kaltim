// Meass tool
map.addControl(mousePositionControl);
const measureType = "Polygon";
const style = new ol.style.Style({
  fill: new ol.style.Fill({
    color: "rgba(255, 255, 255, 0.2)",
  }),
  stroke: new ol.style.Stroke({
    color: "rgba(0, 0, 0, 0.5)",
    lineDash: [10, 10],
    width: 2,
  }),
  image: new ol.style.Circle({
    radius: 5,
    stroke: new ol.style.Stroke({
      color: "rgba(0, 0, 0, 0.7)",
    }),
    fill: new ol.style.Fill({
      color: "rgba(255, 255, 255, 0.2)",
    }),
  }),
});
const labelStyle = new ol.style.Style({
  text: new ol.style.Text({
    font: "14px Calibri,sans-serif",
    fill: new ol.style.Fill({
      color: "rgba(255, 255, 255, 1)",
    }),
    backgroundFill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.7)",
    }),
    padding: [3, 3, 3, 3],
    textBaseline: "bottom",
    offsetY: -15,
  }),
  image: new ol.style.RegularShape({
    radius: 8,
    points: 3,
    angle: Math.PI,
    displacement: [0, 10],
    fill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.7)",
    }),
  }),
});
const tipStyle = new ol.style.Style({
  text: new ol.style.Text({
    font: "12px Calibri,sans-serif",
    fill: new ol.style.Fill({
      color: "rgba(255, 255, 255, 1)",
    }),
    backgroundFill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.4)",
    }),
    padding: [2, 2, 2, 2],
    textAlign: "left",
    offsetX: 15,
  }),
});
const modifyStyle = new ol.style.Style({
  image: new ol.style.Circle({
    radius: 5,
    stroke: new ol.style.Stroke({
      color: "rgba(0, 0, 0, 0.7)",
    }),
    fill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.4)",
    }),
  }),
  text: new ol.style.Text({
    text: "Drag to modify",
    font: "12px Calibri,sans-serif",
    fill: new ol.style.Fill({
      color: "rgba(255, 255, 255, 1)",
    }),
    backgroundFill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.7)",
    }),
    padding: [2, 2, 2, 2],
    textAlign: "left",
    offsetX: 15,
  }),
});
const segmentStyle = new ol.style.Style({
  text: new ol.style.Text({
    font: "12px Calibri,sans-serif",
    fill: new ol.style.Fill({
      color: "rgba(255, 255, 255, 1)",
    }),
    backgroundFill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.4)",
    }),
    padding: [2, 2, 2, 2],
    textBaseline: "bottom",
    offsetY: -12,
  }),
  image: new ol.style.RegularShape({
    radius: 6,
    points: 3,
    angle: Math.PI,
    displacement: [0, 8],
    fill: new ol.style.Fill({
      color: "rgba(0, 0, 0, 0.4)",
    }),
  }),
});
const segmentStyles = [segmentStyle];
// Sumber data untuk menyimpan fitur pengukuran
const measureSource = new ol.source.Vector();
const modify = new ol.interaction.Modify({
  source: measureSource,
  style: modifyStyle,
});
let tipPoint;

function styleFunction(feature, segments, drawType, tip) {
  const styles = [];
  const geometry = feature.getGeometry();
  const type = geometry.getType();
  let point, label, line;
  if (!drawType || drawType === type || type === "Point") {
    styles.push(style);
    if (type === "Polygon") {
      point = geometry.getInteriorPoint();
      label = formatArea(geometry);
      line = new ol.geom.LineString(geometry.getCoordinates()[0]);
    } else if (type === "LineString") {
      point = new ol.geom.Point(geometry.getLastCoordinate());
      label = formatLength(geometry);
      line = geometry;
    }
  }
  if (segments && line) {
    let count = 0;
    line.forEachSegment(function (a, b) {
      const segment = new ol.geom.LineString([a, b]);
      const label = formatLength(segment);
      if (segmentStyles.length - 1 < count) {
        segmentStyles.push(segmentStyle.clone());
      }
      const segmentPoint = new ol.geom.Point(segment.getCoordinateAt(0.5));
      segmentStyles[count].setGeometry(segmentPoint);
      segmentStyles[count].getText().setText(label);
      styles.push(segmentStyles[count]);
      count++;
    });
  }
  if (label) {
    labelStyle.setGeometry(point);
    labelStyle.getText().setText(label);
    styles.push(labelStyle);
  }
  if (
    tip &&
    type === "Point" &&
    !modify.getOverlay().getSource().getFeatures().length
  ) {
    tipPoint = geometry;
    tipStyle.getText().setText(tip);
    styles.push(tipStyle);
  }
  return styles;
}
const formatLength = function (line) {
  const length = ol.sphere.getLength(line);
  let output;
  if (length > 100) {
    output = Math.round((length / 1000) * 100) / 100 + " km";
  } else {
    output = Math.round(length * 100) / 100 + " m";
  }
  return output;
};
const formatArea = function (polygon) {
  const area = ol.sphere.getArea(polygon);
  let output;
  if (area > 10000) {
    output = Math.round((area / 1000000) * 100) / 100 + " km\xB2";
  } else {
    output = Math.round(area * 100) / 100 + " m\xB2";
  }
  return output;
};
const measure = new ol.layer.Vector({
  source: measureSource,
  style: function (feature) {
    return styleFunction(feature, "checked");
  },
});
map.addLayer(measure);
let draw;
// Fungsi untuk menambahkan interaksi pengukuran polyline
function addMeasurement() {
  map.getViewport().style.cursor = "default";
  const drawType = measureType; // Tipe pengukuran diubah menjadi LineString
  const activeTip =
    "Click to continue drawing the " +
    (drawType === "Polygon" ? "polygon" : "line");
  const idleTip = "Click to start measuring";
  let tip = idleTip; // Tip awal saat pengukuran dimulai
  draw = new ol.interaction.Draw({
    source: measureSource,
    type: drawType,
    style: function (feature) {
      return styleFunction(feature, "checked", drawType, tip);
    },
  });
  draw.on("drawstart", function () {
    tip = activeTip;
  });
  draw.on("drawend", function () {
    map.getViewport().style.cursor = "grab";
    modifyStyle.setGeometry(tipPoint);
    map.removeInteraction(draw);
    tip = idleTip;
  });
  map.addInteraction(draw);
}

// Buat tombol kontrol Meass
var rulerControl = new ol.control.Control({
  element: document.getElementById("ruler-button"),
});
map.addControl(rulerControl);
$(rulerControl.element).click(function (e) {
  map.removeInteraction(draw);
  measureSource.clear();
  addMeasurement();
  tip = "Click to start measuring";
});
