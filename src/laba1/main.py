class InvalidArgumentException(Exception):
    pass

class Name:
    def __init__(self, name: str):
        if not name.strip():
            raise InvalidArgumentException(f"'{name}' is not a valid name")
        self._name = name

    def get_value(self) -> str:
        return self._name


class Price:
    def __init__(self, price):
        try:
            price = float(price)
        except ValueError:
            raise InvalidArgumentException(f"Price {price} must be numeric")

        if price <= 0:
            raise InvalidArgumentException(f"Price {price} must be greater than 0")

        if round(price, 2) != price:
            raise InvalidArgumentException(
                f"Price {price} must have at most 2 decimal places"
            )

        self._price = price

    def get_value(self) -> float:
        return self._price


class TotalSeats:
    def __init__(self, total_seats):
        try:
            total_seats = int(total_seats)
        except ValueError:
            raise InvalidArgumentException(f"Seats {total_seats} must be integer")

        if total_seats <= 0:
            raise InvalidArgumentException(f"Seats {total_seats} must be greater than 0")

        self._total_seats = total_seats

    def get_value(self) -> int:
        return self._total_seats


class Station:
    def __init__(self):
        try:
            self.set_name()
            self.set_ticket_price()
            self.set_total_seats()
            self._sold_tickets = 0
        except Exception as e:
            print(e)
            exit(1)

    def get_name(self) -> str:
        return self._name.get_value()

    def set_name(self):
        count = 0
        while True:
            name = input("Введите название станции: ").strip()
            try:
                self._name = Name(name)
                break
            except InvalidArgumentException as e:
                print("\nНеверно введены данные! Убедитесь что вы ввели не пустое название")
                print(e)
                count += 1
                if count >= 10:
                    raise Exception("10 ошибок начинай сначала")

    def set_ticket_price(self):
        count = 0
        while True:
            ticket_price = input("Введите цену билета: ").strip()
            try:
                self._ticket_price = Price(ticket_price)
                break
            except InvalidArgumentException as e:
                print("\nНеверно введены данные! Убедитесь, что вы ввели положительное число с двумя знаками после запятой")
                print(e)
                count += 1
                if count >= 10:
                    raise Exception("10 ошибок начинай сначала")

    def set_total_seats(self):
        count = 0
        while True:
            total_seats = input("Введите количество мест: ").strip()
            try:
                self._total_seats = TotalSeats(total_seats)
                break
            except InvalidArgumentException as e:
                print("\nНеверно введены данные! Убедитесь, что вы ввели целое положительное число")
                print(e)
                count += 1
                if count >= 10:
                    raise Exception("10 ошибок начинай сначала")

    def set_sold_tickets(self, count: int):
        if 0 <= count <= self._total_seats.get_value():
            self._sold_tickets = count
            print(f"Успешно куплено {count} билетов")
        else:
            print(f"Ошибка. Доступно мест только {self._total_seats.get_value()}")

    def get_unsold_tickets_cost(self) -> float:
        return (self._total_seats.get_value() - self._sold_tickets) * self._ticket_price.get_value()


class BoughtTickets:
    def __init__(self):
        try:
            self.set_bought_tickets()
        except Exception as e:
            print(e)
            exit(1)

    def set_bought_tickets(self):
        count = 0
        while True:
            bought_tickets = input("Сколько билетов хотите купить: ").strip()
            try:
                self.check_bought_tickets(bought_tickets)
                self._bought_tickets = int(bought_tickets)
                break
            except InvalidArgumentException as e:
                print("\nНеверно введены данные! Убедитесь, что вы ввели целое положительное число")
                print(e)
                count += 1
                if count >= 10:
                    raise Exception("10 ошибок начинай сначала")

    def check_bought_tickets(self, bought_tickets):
        try:
            value = int(bought_tickets)
        except ValueError:
            raise InvalidArgumentException(f"Tickets {bought_tickets} must be integer")

        if value <= 0:
            raise InvalidArgumentException(f"Tickets {bought_tickets} must be greater than 0")

    def get_value(self) -> int:
        return self._bought_tickets

if __name__ == "__main__":
    station = Station()
    bought_tickets = BoughtTickets()
    print()
    station.set_sold_tickets(bought_tickets.get_value())
    print(f"Станция {station.get_name()}")
    print(f"Осталось билетов на сумму: {station.get_unsold_tickets_cost()} руб")
