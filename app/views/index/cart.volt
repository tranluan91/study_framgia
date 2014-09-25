{{ partial("layouts/index") }}

<div id="content">
    <div class="container">
        <h1>Your cart</h1>

        {% if action is defined and action === "remove" %}
            <div class="alert alert-warning"> {{ name }} has been remove from your cart</div>
        {% elseif action is defined and action === "notexists" %}
            <div class="alert alert-warning"> {{ name }} not in your cart</div>
        {% endif %}

        {% if products is defined %}
            <table class="table">
                <tr>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                {% for index, product in products %}
                <tr>
                    <td>{{ product["name"] }}</td>
                    <td>{{ product["price"] }}</td>
                    <td>{{ link_to("index/cart/remove?product=" ~ index, "Remove", "class": "btn btn-danger",
                                      "title":"Remove from Cart") }}
                    </td>
                </tr>
                {% endfor %}
            </table>
        {% else %}
            <div class="alert alert-warning">You haven't item in your cart!</div>
        {% endif %}
    </div>
</div>
