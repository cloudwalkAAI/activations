/**
 * Created by ROEL on 12/15/2016.
 */
(function($) {
    var c = {};
    c.data = {};
    c.filteredData = [];
    c.filters = {
        category: null,
        subCategory: null,
        area: null
    };
    c.dataTable = null;

    c.init = function() {
        fetchData();
        bindEvents();
        initIonSlider();
    };

    // create Datatable
    function initDataTable(isFresh) {
        var defaultColumns = [
            {
                title: 'ID',
                data: 'location_id',
                visible: false
            },
            {
                title : 'Category',
                data : 'category'
            },
            {
                title : 'Subcategory',
                data : 'category'
            },
            {
                title : 'Venue',
                data : 'venue'
            },
            {
                title : 'Area',
                data : 'area'
            },
            {
                title : 'Subarea',
                data : 'sub_Area'
            },
            {
                title : 'Address',
                data : 'street'
            },
            {
                title : 'Min Rate',
                data : 'rate'
            },
            {
                title : 'Max Rate',
                data : 'rate_Max'
            },
            {
                title : 'EFT Combined',
                data : 'eft'
            },
            {
                title : 'EFT Male',
                data : 'eft_male'
            },
            {
                title : 'EFT Female',
                data : 'eft_female'
            },
            {
                title : 'Target Hits',
                data : 'target_hits'
            },
            {
                title : 'Actual Hits',
                data : 'actual_hits'
            },
            {
                title : 'Actual Hits Female',
                data : 'actual_hits_f'
            },
            {
                title : 'Actual Dry Male',
                data : 'actual_dry_m'
            },
            {
                title : 'Actual Dry Female',
                data : 'actual_dry_f'
            },
            {
                title : 'Actual Dry Male',
                data : 'actual_exper_m'
            },
            {
                title : 'Actual Dry Female',
                data : 'actual_exper_f'
            },
            {
                title : 'LSM',
                data : 'lsm'
            },
            {
                title : 'Image',
                data : 'u_images'
            },
        ]

        if(!isFresh) {
            defaultColumns.push({
                title : 'Actions',
                data : 'cmae_id',
                render : function(data) {
                    return '<a class="del-btn-jois" href="javascript:void(0)" data-id="'+data+'"><img class="btn-delete-edit-size" src="/assets/img/logos/Delete.png" /></a>';
                    // return '<button class="button" data-id="'+data+'">DELETE</button>'
                }
            });
        };

        c.dataTable = $('#filterTable').DataTable({
            "scrollY": true,
            "scrollX": true,
            columns: defaultColumns
        });
    }

    function initIonSlider() {
        $(".sliderRange").ionRangeSlider({
            type: "double",
            grid: true,
            min: 0,
            max: 1000,
            from: 200,
            to: 800
        });
    }

    // initialize base select2
    function initializeSelect2() {
        var categories = parseCategoryItems();
        var subcategories = parseSubCategory();
        var area = parseArea();
        var subArea = parseSubArea();
        var venue = parseVenue();
        var street = parseStreet();
        var lsm = parseLSM();

        $("#inp_category").select2({
            data: categories
        });

        $("#inp_subcategory").select2({
            data: subcategories
        });

        $("#inp_area").select2({
            data: area
        });

        $("#inp_SubArea").select2({
            data: subArea
        });

        $("#inp_venue").select2({
            data: venue
        });

        $("#inp_street").select2({
            data: street
        });

        $("#inp_lsm").select2({
            data: lsm
        });
    }

    // clear datatable
    function clearDataTable() {
        c.filteredData = [];
        if(c.dataTable) {
            c.dataTable.clear().draw();
        }
    }

    // add data to datatable
    function addDataToDataTable(data) {
        clearDataTable();
        c.dataTable.rows.add(data).draw();

    }

    var QueryString = function () {
        // This function is anonymous, is executed immediately and
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = decodeURIComponent(pair[1]);
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(decodeURIComponent(pair[1]));
            }
        }
        return query_string;
    }();

    function saveDataFromDatable() {
        var dataArray = [];
        var dataPar = '';
        var dataJoid = QueryString.a;
        c.dataTable.data().each(function(d) {
            var id = d.location_id;
            dataArray.push(id);
        });
        dataPar = JSON.stringify(dataArray);
        $.ajax({
            type : 'POST',
            url : '/ajax/filter/save_locations',
            data : {
                dataPass : dataPar,
                joId : dataJoid
            },
            success : function (res) {
                console.log(res)
            }
        })
    }

    $('#save_filtered_table').click(function(){
        saveDataFromDatable();
    });

    // filter data
    function filters(key, value) {
        var results = [];
        for(var item of c.data){
            if(item[key] == value)
            {
                results.push(item);
            }
        }
        return results;
    }

    // get events
    function bindEvents() {
        $("#inp_category").on('change', function(e) {
            c.filters.category = e.target.value;
            clearDataTable();

            var data = filters('category', c.filters.category);
            addDataToDataTable(data);

            $("#inp_subcategory").empty();
            $("#inp_subcategory").select2({
                data: parseSubCategory()
            });
        });

        $("#inp_subcategory").on('change', function(e) {
            c.filters.subCategory = e.target.value;
            clearDataTable();

            var data = filters('subcategory', e.target.value);
            addDataToDataTable(data);

            $("#inp_area").empty();
            $("#inp_area").select2({
                data: parseArea()
            });
        });

        $("#inp_area").on('change', function(e) {
            c.filters.area = e.target.value;
            clearDataTable();

            var data = filters('area', e.target.value);
            addDataToDataTable(data);

            $("#inp_subarea").empty();
            $("#inp_subarea").select2({
                data: parseSubArea()
            });
        });

        $('#filterTable').on('click','a.del-btn-jois', function (e) {
            var loc_id = c.dataTable.cell( $(this).parents('td') ).data();
            console.log(loc_id)
            removeLocation(loc_id);
            c.dataTable.row($(this).parents('tr')).remove().draw();
        })
    }

    function removeLocation(loc_id) {
        $.post('/ajax/filter/remove_location/' + loc_id,{}, function(res) {
            console.log(res)
        });
    }

    // get initial data
    function fetchData() {
        fetch('/ajax/filter/get_saved_locations/'+QueryString.a)
            .then(function(res) {
                if(res.status != 200) {
                    fetch('/ajax/filter/get_locations').then(function(res) {
                        res.json().then(function(json) {
                            c.data = json;
                            initializeSelect2();
                            initDataTable(true);
                            addDataToDataTable(c.data);
                        });
                    });
                    return;
                }
                // Convert Response to json
                res.json().then(function(json) {
                    c.data = json;
                    initializeSelect2();
                    initDataTable(false);
                    addDataToDataTable(c.data);
                });
            });
    }

    // parse category
    function parseCategoryItems() {
        var result = [];
        clearDataTable();
        for (var item of c.data) {
            if (item.category != '') {
                if (doesAlreadyExist(result, 'id', item.category)) {
                    continue;
                }

                result.push({
                    id: item.category,
                    text: item.category
                });
                c.filteredData.push(item);
            }
        }

        return result;
    }

    // parse sub category
    function parseSubCategory() {
        var result = [];

        for (var item of c.data) {
            if (c.filters.category != null) {
                if (item.category == c.filters.category
                    && item.subcategory != '') {

                    result.push({
                        id: item.subcategory,
                        text: item.subcategory
                    })
                }
            } else {
                if (item.subcategory != '') {

                    result.push({
                        id: item.subcategory,
                        text: item.subcategory
                    })
                }
            }

        }

        return result
    }

    // parse area
    function parseArea() {
        var result = [];

        for (var item of c.data) {
            if (item.area != '') {
                if (doesAlreadyExist(result, 'id', item.area)) {
                    continue;
                }
                if (item.area == c.filters.area
                    && item.sub_Area != '') {

                    result.push({
                        id: item.area,
                        text: item.area
                    })
                } else {
                    if (item.area != '') {

                        result.push({
                            id: item.area,
                            text: item.area
                        })
                    }
                }
            }
        }

        return result
    }

    // parse subarea
    function parseSubArea() {
        var result = [];

        for (var item of c.data) {
            if (item.sub_Area != '') {
                if (doesAlreadyExist(result, 'id', item.sub_Area)) {
                    continue;
                }
                if (item.sub_Area == c.filters.sub_Area
                    && item.venue != '') {

                    result.push({
                        id: item.sub_Area,
                        text: item.sub_Area
                    })
                } else {
                    if (item.sub_Area != '') {

                        result.push({
                            id: item.sub_Area,
                            text: item.sub_Area
                        })
                    }
                }
            }
        }

        return result
    }

    // parse venue
    function parseVenue() {
        var result = [];

        for (var item of c.data) {
            if (item.venue != '') {
                if (doesAlreadyExist(result, 'id', item.venue)) {
                    continue;
                }

                result.push({
                    id: item.venue,
                    text: item.venue
                })
            }
        }

        return result
    }

    // parse street
    function parseStreet() {
        var result = [];

        for (var item of c.data) {
            if (item.street != '') {
                if (doesAlreadyExist(result, 'id', item.street)) {
                    continue;
                }

                result.push({
                    id: item.street,
                    text: item.street
                })
            }
        }

        return result
    }

    // parse lsm
    function parseLSM() {
        var result = [];

        for (var item of c.data) {
            if (item.lsm != '') {
                if (doesAlreadyExist(result, 'id', item.lsm)) {
                    continue;
                }

                result.push({
                    id: item.lsm,
                    text: item.lsm
                })
            }
        }

        return result
    }

    // check if item already exist
    function doesAlreadyExist(arr, key, value) {
        var found = false;

        for (var obj of arr) {
            if (obj.hasOwnProperty(key) && obj[key] === value) {
                return true;
            }
        }

        return found;
    }

    c.init();
})(jQuery);
