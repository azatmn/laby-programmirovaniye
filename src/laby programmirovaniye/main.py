class InvalidArgumentException(Exception):
    pass

class Name:
    def __init__(self, value: str):
        if not value.strip():
            raise InvalidArgumentException(f"'{value}' is not a valid name")
        self._value = value

    @property
    def value(self) -> str:
        return self._value

class Price:
    def __init__(self, value):
        try:
            value = float(value)
        except ValueError:
            raise InvalidArgumentException(f"Price {value} must be numeric")

        if value <= 0:
            raise InvalidArgumentException(f"Price {value} must be greater than 0")

        if round(value, 2) != value:
            raise InvalidArgumentException(f"Price {value} must have at most 2 decimal places")

        self._value = value

    @property
    def value(self) -> float:
        return self._value


class TotalSeats:
    def __init__(self, value):
        try:
            value = int(value)
        except ValueError:
            raise InvalidArgumentException(f"Seats {value} must be integer")

        if value <= 0:
            raise InvalidArgumentException(f"Seats {value} must be greater than 0")

        self._value = value

    @property
    def value(self) -> int:
        return self._value


class Station:
    def __init__(self):
        try:
            self._name = self._prompt_for_value("Введите название станции: ", Name)
            self._ticket_price = self._prompt_for_value("Введите цену билета: ", Price)
            self._total_seats = self._prompt_for_value("Введите количество мест: ", TotalSeats)
            self._sold_tickets = 0
        except Exception as e:
            print(e)
            exit()

    @staticmethod
    def _prompt_for_value(prompt: str, cls):
        count = 0
        while True:
            raw_value = input(prompt)
            try:
                return cls(raw_value)
            except InvalidArgumentException as e:
                print(f"\nОшибка: {e}")
                count += 1
                if count >= 10:
                    raise Exception("10 ошибок начинай сначала")

    @property
    def name(self) -> str:
        return self._name.value

    def sell_tickets(self, count: int):
        if 0 <= count <= self._total_seats.value:
            self._sold_tickets = count
            print(f"Успешно куплено {count} билетов")
        else:
            print(f"Ошибка. Доступно мест только {self._total_seats.value}")

    @property
    def unsold_tickets_cost(self) -> float:
        return (self._total_seats.value - self._sold_tickets) * self._ticket_price.value

if __name__ == "__main__":
    station = Station()
    bought_tickets = int(input("Сколько билетов хотите купить: "))
    station.sell_tickets(bought_tickets)
    print(f"Станция {station.name}")
    print(f"Осталось билетов на сумму: {station.unsold_tickets_cost} руб")