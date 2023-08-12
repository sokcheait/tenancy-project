export default [
    {
        header:{
            title:"Stock management",
            action:["categories","products"]
        },
        lable: "Category",
        icon: "SquaresPlusIcon",
        link: "categories.index",
        redirect: "categories.index",
        seg: "categories",
        type: "route",
        parent: "categories"
    },
    {
        lable: "Product",
        icon: "CubeIcon",
        link: "products.index",
        redirect: "products.index",
        seg: "products",
        type: "route",
        parent: "products"
    }
]