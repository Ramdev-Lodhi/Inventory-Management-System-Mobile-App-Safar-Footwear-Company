<?php
// print_r($count);
// die();
?>
<!doctype html>
<html lang="en">

<head>
  <?php $this->load->view('includes/header'); ?>

  <title>Dashboard</title>
  <style>
    .tooltip {
      position: absolute;
      text-align: center;
      width: auto;
      padding: 8px;
      font: 12px sans-serif;
      background: lightsteelblue;
      border: 0;
      border-radius: 8px;
      pointer-events: none;
      opacity: 0;
    }
  </style>
</head>
<!-- Sidebar  -->
<?php $this->load->view('includes/sidebar'); ?>
<!-- end sidebar -->

<!-- topbar -->
<?php $this->load->view('includes/top_header'); ?>
<!-- end topbar -->

<!-- dashboard inner -->

<!-- Page Content  -->
<div style="padding-top: 15px; ">
  <div class="row column1">
    <div class="col-lg-3">
      <div class="white_shd full margin_bottom_30">
        <div class="full graph_head">
          <div class="heading1 margin_0">
            <h2>STOCK IN GODOWN</h2>
          </div>
        </div>
        <!-- <div class="map_section padding_infor_info"> -->
        <canvas id="pie_chart"></canvas>
        <!-- </div> -->
      </div>
      <div class="modal" id="subChartModal" tabindex="-1">
        <div class="modal-dialog" style="max-width: 830px; margin: 1.75rem auto;">
          <div class="modal-content">
            <span class="close" >&times;</span>
            <div class="modal-body">
              <div id="sub_doughnut_chart"></div>
              <div class="tooltip" id="tooltip"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- </div> -->
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://d3js.org/d3.v7.min.js"></script>
<script>
  $(function () {
    var category = <?php echo json_encode($data, JSON_HEX_TAG); ?>;
    var countData = <?php echo json_encode($count, JSON_HEX_TAG); ?>;
    var counts = countData[0];
    var count = [
      counts.gents,
      counts.ladies,
      counts.kids,
      counts.kiddy
    ];
    var labels = category.map(function (item) { return item.name; });
    var total = count.reduce((a, b) => a + b, 0);
    var mainChart = new Chart(document.getElementById("pie_chart").getContext("2d"), {
      type: 'pie',
      data: {
        datasets: [{
          data: count,
          backgroundColor: [
            "rgba(33, 150, 243, 1)",
            "tan",
            "rgba(103, 58, 183, 1)",
            "rgba(255, 99, 132, 1)",
          ],
        }],
        labels: labels
      },
      options: {
        responsive: true,

        onClick: function (event, elements) {
          if (elements.length > 0) {
            var index = elements[0].index + 1;
            showSubPieChart(index);
          }
        }
      }
    });

    // Tooltip element
    var tooltip = d3.select("#tooltip");
    var modal = document.getElementById("subChartModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function () {
      modal.style.display = "none";
    }

    window.onClick = function (event, elements) {
      if (elements.length > 0) {
        var categoryId = category[elements[0]._index].id; // Get the category ID from the clicked element
        showSubPieChart(categoryId);
      }
    }

    function showSubPieChart(categoryId) {
  // console.log(categoryId)
  var myurl = "<?= base_url() ?>welcome/subdata/" + categoryId;
  $.ajax({
    url: myurl,
    method: 'GET',
    data: { categoryId: categoryId },
    dataType: 'json',
    success: function (response) {
      console.log(response);

      // Process data for hierarchical format
      const hierarchicalData = { name: "STOCK IN GODOWN", children: [] };

      response.forEach(item => {
        let sizeNode = hierarchicalData.children.find(child => child.name === item.size);
        if (!sizeNode) {
          sizeNode = { name: item.size, children: [] };
          hierarchicalData.children.push(sizeNode);
        }
        sizeNode.children.push({ name: item.a_name, size: +item.size_count, color: item.a_color });
      });

      // Create sunburst chart
      const width = 800;
      const radius = width / 2;

      const color = d3.scaleOrdinal()
        .domain(response.map(d => d.name))
        .range(categoryId === 1 ? ["rgba(33, 150, 243, 1)"] :
               categoryId === 2 ? ["tan"] :
               categoryId === 3 ? ["rgba(103, 58, 183, 1)"] :
               categoryId === 4 ? ["rgba(255, 99, 132, 1)"] : []);

      const partition = d3.partition()
        .size([2 * Math.PI, radius]);

      const arc = d3.arc()
        .startAngle(d => d.x0)
        .endAngle(d => d.x1)
        .innerRadius(d => d.y0)
        .outerRadius(d => d.y1);

      // Remove existing chart if present
      d3.select("#sub_doughnut_chart").selectAll("*").remove();

      const svg = d3.select("#sub_doughnut_chart").append("svg")
        .attr("width", width)
        .attr("height", width)
        .append("g")
        .attr("transform", `translate(${width / 2},${width / 2})`);

      const root = d3.hierarchy(hierarchicalData)
        .sum(d => d.size);

      partition(root);

      // Tooltip element
      const tooltip = d3.select("body").append("div")
        .attr("class", "tooltip")
        .style("opacity", 0);

      svg.selectAll("path")
        .data(root.descendants())
        .enter().append("path")
        .attr("d", arc)
        .style("fill", d => color(d.data.name))
        .style("stroke", "#fff")
        .on("mouseover", function (event, d) {
          tooltip.transition()
            .duration(200)
            .style("opacity", .9);
          tooltip.html(`Name: ${d.data.name}<br>Box Count: ${d.value}<br> Color:${color(d.data.name)}`)
            .style("left", (event.pageX + 10) + "px")
            .style("top", (event.pageY - 28) + "px");
        })
        .on("mousemove", function (event) {
          tooltip.style("left", (event.pageX + 10) + "px")
            .style("top", (event.pageY - 28) + "px");
        })
        .on("mouseout", function (d) {
          tooltip.transition()
            .duration(500)
            .style("opacity", 0);
        })
        .append("title")
        .text(d => `${d.data.name}\n${d.value}`);

      svg.selectAll("text")
        .data(root.descendants())
        .enter().append("text")
        .attr("transform", function (d) {
          if (d.depth === 0) { // Check if it's the root node
            return `rotate(360) translate(${width / 100},0)`; // Rotate by 360 degrees and translate to the center
          } else {
            const x = (d.x0 + d.x1) / 2 * 180 / Math.PI;
            const y = (d.y0 + d.y1) / 2;
            return `rotate(${x - 90}) translate(${y},0) rotate(${x < 180 ? 0 : 180})`;
          }
        })
        .attr("dy", "0.35em")
        .attr("text-anchor", "middle")
        .attr("fill", "white") // Set text color to white
        .attr("font-size", "12px") // Set font size to 12px
        .text(d => {
          if (d.depth === 0) { // If it's the root node
            return categoryId === 1 ? "Gents" :
                   categoryId === 2 ? "Ladies" :
                   categoryId === 3 ? "Kid" :
                   categoryId === 4 ? "Kiddy" : ""; // Return category name for the root node
          } else {
            return `${d.data.name} (${d.value})`; // Return name and box count for other nodes
          }
        });

      modal.style.display = "block";
    },
    error: function (xhr, status, error) {
      console.error("Error fetching subcategory data:", status, error);
    }
  });
}
});

</script>
<!-- end dashboard inner -->
<?php $this->load->view('includes/footer'); ?>