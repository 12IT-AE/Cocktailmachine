import time
from models import Order,Maintenance
from datetime import datetime
import executeorder
import executemaintenance 
#Aktualisierung des Status für offene und laufende Einträge
def abort_all_incomplete_entries():
    for status in (0, 1):  # Status 0 = offen, Status 1 = in Bearbeitung
        for order in Order.Database().selectByStatus(status):
            Order.Database().updateStatus(order.id, 3)  # Status 3 = abgebrochen
        for maintenance in Maintenance.Database().selectByStatus(status):
            Maintenance.Database().updateStatus(maintenance.id, 3)

#Verarbeitung von Einträgen basierend auf ihrem Status
def process_pending_or_processing(pending, processing, execute_function, update_function):
    if processing:  # Bearbeite die ersten Einträge, die bereits verarbeitet werden
        execute_function(processing[0])
    elif pending:  # Starte Bearbeitung der ersten offenen Einträge
        print(f"Processing: {pending[0]}")
        update_function(pending[0].id, 1)  # Setze Status auf "in Bearbeitung"


def check():
    while True:
        # Lade Daten aus der Datenbank
        pending_orders = Order.Database().selectByStatus(0)
        processing_orders = Order.Database().selectByStatus(1)
        pending_maintenance = Maintenance.Database().selectByStatus(0)
        processing_maintenance = Maintenance.Database().selectByStatus(1)
        
        # Verarbeite Wartungsaufgaben (Priorität)
        if pending_maintenance or processing_maintenance:
                process_pending_or_processing(
                pending_maintenance,
                processing_maintenance,
                executemaintenance.executeMaintainence,
                Maintenance.Database().updateStatus,
                )      
        else:
            # Verarbeite Bestellungen (wenn keine Wartungsaufgaben vorhanden sind)
            process_pending_or_processing(
                pending_orders,
                processing_orders,
                executeorder.executeOrders,
                Order.Database().updateStatus,
            )
        # Wenn keine Einträge zu verarbeiten sind, warte kurz
        if not (pending_orders or processing_orders or pending_maintenance or processing_maintenance):
            time.sleep(5)


if __name__ == "__main__":
        abort_all_incomplete_entries()
        now = datetime.now()
        Order.Database().insertOrder(0,4,now,now)
        check()
