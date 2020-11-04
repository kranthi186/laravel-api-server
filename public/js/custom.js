$(function () {
    function readURL(input, preview_class) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("." + preview_class).attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#logo").on("change", function () {
        readURL(this, "preview_logo");
    });
    $("#cover").on("change", function () {
        readURL(this, "preview_cover");
    });
    $("#featured").on("change", function () {
        readURL(this, "preview_featured");
    });
    $("#product").on("change", function () {
        readURL(this, "preview_product");
    });
    $("#photo").on("change", function () {
        readURL(this, "preview_photo");
    });

    $("#name").on("keyup", function (event) {
        console.log(event.key);
        if (event.key != "Escape") {
            $("#retailer_product_select").show();
            let searchValue = event.target.value;
            document
                .querySelectorAll("#retailer_product_select > option")
                .forEach((option) => {
                    if (
                        $(option)
                            .text()
                            .toLowerCase()
                            .includes(searchValue.toLowerCase())
                    ) {
                        $(option).css("display", "block");
                    } else {
                        $(option).css("display", "none");
                    }
                });
        } else {
            $("#retailer_product_select").hide();
        }
    });
    $("#retailer_product_select").on("click", function (event) {
        console.log($(this).val()[0]);
        $.ajax({
            url: "/api/product/" + $(this).val()[0],
            method: "post",
            dataType: "json",
            // headers: {authorization: 'Bearer ' + $auth_token},
            success: function (data) {
                console.log(data.name);
                $("#name").val(data.name);
                $("#product-category").val(data.category);

                let type_ids = ["#indica", "#sativa", "#hybrid", "#cbd"];
                [0, 1, 2, 3].forEach((value) => {
                    if (data.types.includes(value)) {
                        $(type_ids[value]).prop("checked", true);
                    } else {
                        $(type_ids[value]).prop("checked", false);
                    }
                });

                if (data.image != "") {
                    $(".preview_product").attr("src", data.image);
                }
                $("#product_hidden").val(data.image);

                if (data.popular == 1) {
                    $("#popular-yes").prop("checked", true);
                } else {
                    $("#popular-no").prop("checked", true);
                }

                $("#description").val(data.description);

                var ionskin = "flat";

                function my_prettify(n) {
                    // var num = Math.log2(n);
                    // return n + " → " + (+num.toFixed(3));
                    return n + "%";
                }

                for (var i = 0; i < $(".characteristic").length; i++) {
                    $($(".characteristic")[i])
                        .data("ionRangeSlider")
                        .update({
                            from: Object.values(data.attributes)[i],
                        });
                }

                $("#price_product").val(data.prices[0]);
                $("#price_half").val(data.prices[1]);
                $("#price_one").val(data.prices[2]);
                $("#price_ounce").val(data.prices[3]);
            },
        });
        $(this).hide();
    });

    $("#product-category").on("change", function () {
        const category = $(this).val();
        if (category % 2 == 0) {
            $(".price_quantity").hide();
            $(".price_weight").show();
        } else {
            $(".price_quantity").show();
            $(".price_weight").hide();
        }
    });

    if ($("#product-category").val() % 2 == 0) {
        $(".price_quantity").hide();
        $(".price_weight").show();
    } else {
        $(".price_quantity").show();
        $(".price_weight").hide();
    }
});
