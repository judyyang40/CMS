        <div class="col-md-12" id="footer">
    	    New Goods &copy; 2016. All right reserved.
        </div>
    </div>
    <script>
        $(document).ready(function() {

                $.fn.dataTable.moment('MM/DD/YYYY');
        		$('#table').dataTable({
                    "bStateSave": true,
                    "columns": [
                        null,
                        null,
                        {"orderable": false},
                        null
                    ]
                });
                $('#table').dataTable().columnFilter({aoColumns: [{type: "text"}, {type: "text"}, null, {type: "text"}]});

        });
    </script>
</body>
</html>