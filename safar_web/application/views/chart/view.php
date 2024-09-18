<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


<!-- Qualiy First Chart Start -->
<script>
  $(function () {
    var categoryData = <?php echo json_encode($category_counts_first); ?>;

    // Map category data to the format needed for the chart
    var count = categoryData.map(function (item) {
      return item.count;
    });

    var labels = categoryData.map(function (item) {
      return item.name; // Customize the label as needed
    });

    var colors = [
      "rgba(33, 150, 243, 1)",
      "green",
      "rgba(103, 58, 183, 1)",
      "rgba(255, 99, 132, 1)"
    ];

    var mainChart = new Chart(document.getElementById("pie_chart").getContext("2d"), {
      type: 'pie',
      data: {
        datasets: [{
          data: count,
          backgroundColor: colors,
        }],
        labels: labels
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                let label = tooltipItem.label || '';
                if (label) {
                  label += ': ';
                }
                label += Math.round(tooltipItem.raw * 100) / 100;
                return label;
              }
            }
          },
          datalabels: {
            display: true,
            formatter: (value, context) => {
              return value;
            },
            color: 'white',
            font: {
              weight: 'bold'
            }
          }
        },
        onClick: function (event, elements) {
          if (elements.length > 0) {
            var index = elements[0].index;
            var categoryId = categoryData[index].category_id;
            var categoryColor = colors[index];
            var categoryName = labels[index];
            showSubPieChart(categoryId, categoryColor, categoryName);
          }
        }
      },
      plugins: [ChartDataLabels]
    });
    var modal = document.getElementById("subChartModal");

    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    function showSubPieChart(categoryId, categoryColor, categoryName) {
      var quality = "FIRST";
      var myurl = "<?= base_url() ?>welcome/subdata/" + categoryId + "/" + quality;
      console.log(myurl);
      $.ajax({
        url: myurl,
        method: 'GET',
        data: { categoryId: categoryId },
        dataType: 'json',
        success: function (response) {
          console.log(response)
          const hierarchicalData = { name: categoryName, children: [] };

          response.forEach(item => {
            if (item.category == categoryId) {
              let articleNode = hierarchicalData.children.find(child => child.name === item.article_name);
              if (!articleNode) {
                articleNode = { name: item.article_name, children: [] };
                hierarchicalData.children.push(articleNode);
              }
              item.color.forEach(colorInfo => {
                articleNode.children.push({ name: colorInfo.size_name, size: colorInfo.quantity_in_g });
              });
            }
          });

          const width = 700;
          const radius = width / 2;

          const color = d3.scaleOrdinal()
            .domain(response.map(d => d.name))
            .range([categoryColor]);

          const partition = d3.partition()
            .size([2 * Math.PI, radius]);

          const arc = d3.arc()
            .startAngle(d => d.x0)
            .endAngle(d => d.x1)
            .innerRadius(d => d.y0)
            .outerRadius(d => d.y1);

          d3.select("#sub_doughnut_chart").selectAll("*").remove();

          const svg = d3.select("#sub_doughnut_chart").append("svg")
            .attr("width", width)
            .attr("height", width)
            .append("g")
            .attr("transform", `translate(${width / 2},${width / 2})`);

          const root = d3.hierarchy(hierarchicalData)
            .sum(d => d.size);

          partition(root);

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
              d3.select(this).style("stroke-width", "4px");  // Increase stroke width on hover
              tooltip.transition()
                .duration(200)
                .style("opacity", .9);
              tooltip.html(`Name: ${d.data.name}<br>Box Count: ${d.value}`)
                .style("left", (event.pageX + 10) + "px")
                .style("top", (event.pageY - 28) + "px");
            })
            .on("mousemove", function (event) {
              tooltip.style("left", (event.pageX + 10) + "px")
                .style("top", (event.pageY - 28) + "px");
            })
            .on("mouseout", function (d) {
              d3.select(this).style("stroke-width", "1px");  // Reset stroke width on mouse out
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
            .attr("fill", "white")
            .attr("font-size", "9px")
            .text(d => {
              const maxTextLength = (d.x1 - d.x0) * radius / 10;
              const text = d.depth === 0 ? categoryName : `${d.data.name} (${d.value})`;
              return text.length > maxTextLength ? text.substring(0, maxTextLength) + '...' : text;
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


<!-- Quality First chart End  -->

<!-- Quality Second chart Start  -->

<script>
  $(function () {
    var categoryData = <?php echo json_encode($category_counts_second); ?>;
    // Map category data to the format needed for the chart
    var count = categoryData.map(function (item) {
      return item.count;
      // console.log(count)

    });

    var labels = categoryData.map(function (item) {
      return item.name; // Customize the label as needed
    });

    var colors = [
      "rgba(33, 150, 243, 1)",
      "green",
      "rgba(103, 58, 183, 1)",
      "rgba(255, 99, 132, 1)"
    ];

    var mainChart = new Chart(document.getElementById("pie_chart_second").getContext("2d"), {
      type: 'pie',
      data: {
        datasets: [{
          data: count,
          backgroundColor: colors,
        }],
        labels: labels
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                let label = tooltipItem.label || '';
                if (label) {
                  label += ': ';
                }
                label += Math.round(tooltipItem.raw * 100) / 100;
                return label;
              }
            }
          },
          datalabels: {
            display: true,
            formatter: (value, context) => {
              return value;
            },
            color: 'white',
            font: {
              weight: 'bold'
            }
          }
        },
        onClick: function (event, elements) {
          if (elements.length > 0) {
            var index = elements[0].index;
            var categoryId = categoryData[index].category_id;
            var categoryColor = colors[index];
            var categoryName = labels[index];
            showSubPieChart_second(categoryId, categoryColor, categoryName);
          }
        }
      },
      plugins: [ChartDataLabels]
    });

    var tooltip = d3.select("#tooltip");
    var modal = document.getElementById("subChartModal_second");

    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    function showSubPieChart_second(categoryId, categoryColor, categoryName) {
      var quality = "SECOND";
      var myurl = "<?= base_url() ?>welcome/subdata/" + categoryId + "/" + quality;
      console.log(myurl);
      $.ajax({
        url: myurl,
        method: 'GET',
        data: { categoryId: categoryId },
        dataType: 'json',
        success: function (response) {
          const hierarchicalData = { name: categoryName, children: [] };

          response.forEach(item => {
            if (item.category == categoryId) {
              let articleNode = hierarchicalData.children.find(child => child.name === item.article_name);
              if (!articleNode) {
                articleNode = { name: item.article_name, children: [] };
                hierarchicalData.children.push(articleNode);
              }
              item.color.forEach(colorInfo => {
                articleNode.children.push({ name: colorInfo.size_name, size: colorInfo.quantity_in_g });
              });
            }
          });

          const width = 700;
          const radius = width / 2;

          const color = d3.scaleOrdinal()
            .domain(response.map(d => d.name))
            .range([categoryColor]);

          const partition = d3.partition()
            .size([2 * Math.PI, radius]);

          const arc = d3.arc()
            .startAngle(d => d.x0)
            .endAngle(d => d.x1)
            .innerRadius(d => d.y0)
            .outerRadius(d => d.y1);

          d3.select("#sub_doughnut_chart_second").selectAll("*").remove();

          const svg = d3.select("#sub_doughnut_chart_second").append("svg")
            .attr("width", width)
            .attr("height", width)
            .append("g")
            .attr("transform", `translate(${width / 2},${width / 2})`);

          const root = d3.hierarchy(hierarchicalData)
            .sum(d => d.size);

          partition(root);

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
              d3.select(this).style("stroke-width", "4px");  // Increase stroke width on hover
              tooltip.transition()
                .duration(200)
                .style("opacity", .9);
              tooltip.html(`Name: ${d.data.name}<br>Box Count: ${d.value}`)
                .style("left", (event.pageX + 10) + "px")
                .style("top", (event.pageY - 28) + "px");
            })
            .on("mousemove", function (event) {
              tooltip.style("left", (event.pageX + 10) + "px")
                .style("top", (event.pageY - 28) + "px");
            })
            .on("mouseout", function (d) {
              d3.select(this).style("stroke-width", "1px");  // Reset stroke width on mouse out
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
            .attr("fill", "white")
            .attr("font-size", "9px")
            .text(d => {
              const maxTextLength = (d.x1 - d.x0) * radius / 10;
              const text = d.depth === 0 ? categoryName : `${d.data.name} (${d.value})`;
              return text.length > maxTextLength ? text.substring(0, maxTextLength) + '...' : text;
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

<script>
  $(function () {
    var job = <?php echo json_encode($job); ?>;
    // console.log(job);

    var statusCounts = { success: 0, inProgress: 0};
    
    job.forEach(function(item) {
      if (item.status == '1') {
        statusCounts.success++;
      } else if (item.status == '0') {
        statusCounts.inProgress++;
      }
      // if (item.payment_status == '1') {
      //   statusCounts.paid++;
      // }
    });

    var data = [statusCounts.success, statusCounts.inProgress];
    var labels = ['Success', 'In Progress'];
    var colors = [ "rgb(0, 0, 255)", "rgb(255, 0, 0) "];

    var mainChart = new Chart(document.getElementById("pie_jobsheet").getContext("2d"), {
      type: 'doughnut',
      data: {
        datasets: [{
          data: data,
          backgroundColor: colors,
        }],
        labels: labels
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function (tooltipItem) {
                let label = tooltipItem.label || '';
                if (label) {
                  label += ': ';
                }
                label += Math.round(tooltipItem.raw * 100) / 100;
                return label;
              }
            }
          },
          datalabels: {
            display: true,
            formatter: (value, context) => {
              return value;
            },
            color: 'white',
            font: {
              weight: 'bold'
            }
          }
        },
      },
      plugins: [ChartDataLabels]
    });
  });
</script>



<!-- Quality Second chart End  -->