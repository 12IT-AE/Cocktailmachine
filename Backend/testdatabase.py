import time
from models import Order
from datetime import datetime
import executeorder as executeorder

#alle aktuellen bestellungen bei starten abbrechen
abr = Order.Database().selectByStatus(0)
for order in abr:
     Order.Database().updateStatus(order.id,4)
abr = Order.Database().selectByStatus(1)
for order in abr:
     Order.Database().updateStatus(order.id,4)

def checkOrders():
    while True:
        pending_orders = Order.Database().selectByStatus(0)
        processing_orders = Order.Database().selectByStatus(1)

        if processing_orders:
                executeorder.executeOrders(processing_orders[0])
        
        if pending_orders:
                print(pending_orders[0])
                Order.Database().updateStatus(pending_orders[0].id, 1)
        
        # Wait before checking again to avoid tight looping
        time.sleep(5)
        








   


now = datetime.now()
Order.Database().insertOrder(0,4,now,now)
checkOrders()


#Maintanace einbauen