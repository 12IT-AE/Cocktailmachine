import time
from models import Order
from datetime import datetime
import executeorder as executeorder
def checkOrders():
    pending = Order.Database().selectFirstByStatus(0)
    processing = Order.Database().selectFirstByStatus(1)
    if not pending and not processing:
        time.sleep(2)
        checkOrders() # recursive call
    
    if processing not in [None, []]:

        executeorder.executeOrders(processing)

        time.sleep(10)
        Order.Database().updateStatus(processing.id,2)
        checkOrders()
    


    if pending not in [None, []]:
        print(pending)
        Order.Database().updateStatus(pending.id,1)
        
    checkOrders() # recursive call
now = datetime.now()
Order.Database().insertOrder(0,5,now,now)
checkOrders()
