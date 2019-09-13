# parking_fee_counter
Calculates the total parking fee for a parking

Taxan på parkeringsplatsen är:
Alla dagar 09:00 - 18:00: 5 kr / tim
Övrig tid: 0 kr / tim
Max pris per dygn: 25 kr
Första timmen (första timmen som inte är 0 kr / tim): 10 kr / tim (därefter 5 kr / tim enligt ovan)
        
Tidpunkter skall kunna anges med flera dygns skillnad, t.ex. från igår 10:00 -> imorgon 22:00.
Exempel: Idag 10:00 -> Idag 12:00 skall bli en total kostnad på 15 kr. (Första timmen 10 kr / tim + därefter 5 kr / tim).
