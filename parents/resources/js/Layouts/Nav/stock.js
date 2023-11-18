export default [
    {
        header:{
            title:"Stock management",
            action:["supplier","item","purchase-order","receive","back-order","stock","returned"]
        },
        lable: "Supplier",
        icon: "TruckIcon",
        link: "supplier.index",
        redirect: "supplier.index",
        seg: "supplier",
        type: "route",
        parent: "supplier"
    },
    {
        lable: "Item",
        icon: "RectangleGroupIcon",
        link: "item.index",
        redirect: "item.index",
        seg: "item",
        type: "route",
        parent: "item"
    },
    {
        lable: "Purchase order",
        icon: "ListBulletIcon",
        link: "purchase-order.index",
        redirect: "purchase-order.index",
        seg: "purchase-order",
        type: "route",
        parent: "purchase-order"
    },
    {
        lable: "Receiving",
        icon: "ClipboardDocumentListIcon",
        link: "receive.index",
        redirect: "receive.index",
        seg: "receive",
        type: "route",
        parent: "receive"
    },
    {
        lable: "Back Order",
        icon: "ArrowsRightLeftIcon",
        link: "back-order.index",
        redirect: "back-order.index",
        seg: "back-order",
        type: "route",
        parent: "back-order"
    },
    {
        lable: "Stock",
        icon: "CubeIcon",
        link: "stock.index",
        redirect: "stock.index",
        seg: "stock",
        type: "route",
        parent: "stock"
    },
    {
        lable: "Returned",
        icon: "ArrowUturnLeftIcon",
        link: "returned.index",
        redirect: "returned.index",
        seg: "returned",
        type: "route",
        parent: "returned"
    },
]