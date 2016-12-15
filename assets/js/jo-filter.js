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

        c.dataTable = $('#filterTable').DataTable({
            columns: [
                {
                    title : 'Venue',
                    data : 'venue'
                },
                {
                    title : 'Area',
                    data : 'area'
                },
                {
                    title : 'Address',
                    data : 'street'
                },
                {
                    title : 'Rate',
                    data : 'rate'
                },
                {
                    title : 'Image',
                    data : 'u_images'
                },
                {
                    title : 'Actions',
                    data : 'id',
                    render : function(data) {
                        return '<a class="del-btn-cmtuva" href="#" data-id="'+data+'" ><img class="btn-delete-edit-size" src="/assets/img/logos/Delete.png" /></a>';
                        // return '<button class="button" data-id="'+data+'">DELETE</button>'
                    }
                }
            ]
        });
    };

    // initialize base select2
    function initializeSelect2() {
        var categories = parseCategoryItems();
        var subcategories = parseSubCategory();
        var area = parseArea();
        var subArea = parseSubArea();
        var venue = parseVenue();
        var street = parseStreet();
        var lsm = parseLSM();

        // console.log(categories);

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

    function destroyDataTable() {
        c.filteredData = [];
        c.dataTable.clear().draw();
    }

    function initializeDataTable(data) {
        destroyDataTable();
        c.dataTable.rows.add(data).draw();

    }

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
            destroyDataTable();

            var data = filters('category', c.filters.category);
            initializeDataTable(data);

            $("#inp_subcategory").empty();
            $("#inp_subcategory").select2({
                data: parseSubCategory()
            });
        });

        $("#inp_subcategory").on('change', function(e) {
            c.filters.subCategory = e.target.value;
            destroyDataTable();

            var data = filters('subcategory', e.target.value);
            initializeDataTable(data);

            $("#inp_area").empty();
            $("#inp_area").select2({
                data: parseArea()
            });
        });

        $("#inp_area").on('change', function(e) {
            c.filters.area = e.target.value;
            destroyDataTable();

            var data = filters('area', e.target.value);
            initializeDataTable(data);

            $("#inp_subarea").empty();
            $("#inp_subarea").select2({
                data: parseSubArea()
            });
        });
    }

    // get initial data
    function fetchData() {
        fetch('/ajax/filter/get_locations')
            .then(function(res) {

                // Convert Response to json
                res.json().then(function(json) {
                    c.data = json;

                    initializeSelect2();
                    initializeDataTable(c.data);
                });
        });
    }

    // parse category
    function parseCategoryItems() {
        var result = [];
        destroyDataTable();
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

    function parseVenue() {
        var result = [];

        for (var item of c.data) {
            if (item.venue != '') {
                console.log(doesAlreadyExist(result, 'id', item.venue));
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

    function parseStreet() {
        var result = [];

        for (var item of c.data) {
            if (item.street != '') {
                console.log(doesAlreadyExist(result, 'id', item.street));
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

    function parseLSM() {
        var result = [];

        for (var item of c.data) {
            if (item.lsm != '') {
                console.log(doesAlreadyExist(result, 'id', item.lsm));
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

// $("#inp_category").select2({
//     placeholder: 'Select Category',
//     allowClear: true,
//     ajax: {
//         url: "/ajax/filter/get_categories",
//         cache: true,
//         dataType: 'json',
//         processResults: function (data) {
//             var results = [{
//                 id: '0',
//                 text:'Select...'
//             }];
//             $.each(data, function(index, item){
//                 results.push({
//                     id: item.category,
//                     text: item.category
//                 });
//             });
//             return {
//                 results: results
//             };
//         }
//     }
// }).on('select2:select', function () {
//     $("#inp_subcategory").select2();
// });
// $("#inp_subcategory").select2({
//     placeholder: 'Select Subcategory',
//     allowClear: true,
//     ajax: {
//         url: "/ajax/filter/get_subcategories",
//         cache: true,
//         data: function (params) {
//             return {
//                 term: params.term,
//                 category: $('#inp_category').val()
//             };
//         },
//         dataType: 'json',
//         processResults: function (data) {
//             var results = [{
//                 id: '0',
//                 text:'Select...'
//             }];
//             $.each(data, function(index, item){
//                 results.push({
//                     id: item.subcategory,
//                     text: item.subcategory
//                 });
//             });
//             results.push({
//                 id: '',
//                 text:'Select...'
//             });
//             return {
//                 results: results
//             };
//         }
//     }
// });
$(".sliderRange").ionRangeSlider({
    type: "double",
    grid: true,
    min: 0,
    max: 1000,
    from: 200,
    to: 800
});
