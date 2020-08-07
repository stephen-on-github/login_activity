/**
 * Graph object
 *
 * @member graph      - The HTML element used for the chart
 * @member form       - The form HTML element containing the filters
 * @member apiUrl     - The server URL to fetch data from
 *
 * @method getFilters - Get all filters from the form as an array
 * @method filter     - filter the graph to show data with the applied filters
 * @method draw       - draw the graph, using supplied data
 */
class Mtx_graph
{
    constructor(args)
    {
        // Set member data
        this.graph  = document.querySelector(args.graph);
        this.form   = document.querySelector(args.form);
        this.apiUrl = args.apiUrl;

        // Load Google Charts
        google.charts.load('current', {'packages':['line']});

        // Add event listeners to form fields
        const chart = this;
        Array.from(this.form.getElementsByClassName('login-activity-filter')).forEach(filter => {
            filter.addEventListener('change', function() {
                chart.filter();
            });
        });
    }

    // Get all filters from the form as an array
    getFilters()
    {
        return Array.from(new FormData(this.form));
    }

    // Apply the filters to the graph
    filter()
    {
        // Form a URL to communicate with the API
        const url = this.apiUrl + '?' + (new URLSearchParams(this.getFilters()).toString());

        // Store the chart in a constant, in case the context of `this` changes.
        const chart = this;

        // Make the request
        // Update the chart, if successful, otherwise log an error.
        fetch(url)
            .then((response) => response.json())
            .then(data => { chart.draw(data) })
            .catch(error => { console.error('Error:', error); });
    }

    /**
     * Draw the graph itself
     *
     * @param args - keys and rows
     */
    draw(args)
    {
        let data = new google.visualization.DataTable();

        // Specify the keys
        data.addColumn('string', 'Time');
        Array.from(args.keys).forEach(keys => {
            data.addColumn('number', keys);
        });

        // Load the data points
        data.addRows(args.rows);

        // Other configuration
        const options = {
            width: '100%',
            height: 500,
            axes: {
                x: { 0: {side: 'top' } }
            },
            vAxes: {
                0: { title: 'Logins' }
            }
        };

        // Draw the chart
        const chart = new google.charts.Line(this.graph);
        chart.draw(data, google.charts.Line.convertOptions(options));
    }
}

(function() {
    // Load the graph object
    const graph = new Mtx_graph({
        graph:  '#login-activity-chart',
        form:   '#login-activity-filters',
        apiUrl: '/api/logins'
    });

    // Draw the graph, with the existing filters applied
    graph.filter();
})();


// Initialise date-range pickers
Array.from(document.getElementsByClassName('daterangepicker')).forEach(picker => {
    new Litepicker({
        element: picker,
        format: 'D MMMM YYYY',
        numberOfColumns: 2,
        numberOfMonths: 2,
        singleMode: false,
        splitView: true,
        onSelect: function(start, end) {
            const id = picker.id;
            const startField = document.getElementById(id + '-start');
            const endField   = document.getElementById(id + '-end');
            const event = document.createEvent('HTMLEvents');

            // When a date is selected, update the hidden fields containing the start and end dates.
            startField.value = start ? start.toISOString().slice(0, 10) : '';
            endField.value   =   end ?   end.toISOString().slice(0, 10) : '';

            // Trigger a change event.
            event.initEvent('change', true, false);
            startField.dispatchEvent(event);
        }
    });
});

