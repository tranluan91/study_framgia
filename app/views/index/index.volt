{{ partial("layouts/index") }}

{% block content %}
<div id="content">
    <div class="container">
    {% if auth is defined %}
        <h1>Products</h1>
        {% if success is defined %}
            <div class="alert alert-warning"> Added to your cart</div>
        {% endif %}

        <table class="table">
            <tr>
                <th>Product name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            {% for product in products %}
            <tr>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ link_to("index/index/add?product=" ~ product.id, "Add",  "class": "btn btn-success") }}</td>
            </tr>
            {% endfor %}
        </table>
    {% else %}
        <a href="<?= $this->facebook->getLoginUrl(['scope' => $this->config->facebook->scope, 'redirect_uri' => $url .$this->url->get('user/facebook')]) ?>"><span class="fa"></span>Facebook Login
        </a>
    {% endif %}
    </div>
</div>
{% endblock %}
