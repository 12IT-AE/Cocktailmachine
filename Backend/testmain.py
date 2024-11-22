import time
from models import Order,Maintenance
from datetime import datetime
import executeorder
import Backend.executemaintenance as executemaintenance
#alle aktuellen bestellungen bei starten abbrechen
abr = Order.Database().selectByStatus(0)
for order in abr:
     Order.Database().updateStatus(order.id,3)
abr = Order.Database().selectByStatus(1)
for order in abr:
     Order.Database().updateStatus(order.id,3)
abr = maintenance = Maintenance.Database().selectByStatus(0)
for maintenance in abr:
      Maintenance.Database().updateStatus(maintenance.id,3)

def checkOrders():
    while True:
        pending_orders = Order.Database().selectByStatus(0)
        processing_orders = Order.Database().selectByStatus(1)
        maintenance = Maintenance.Database().selectByStatus(0)
        if maintenance:
                executemaintenance.executeMaintainence(maintenance[0])
        else:
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