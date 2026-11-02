from sqlalchemy import create_engine, Column, Integer, String
from sqlalchemy.orm import declarative_base, sessionmaker

engine = create_engine(
    "mysql+mysqlconnector://root:@localhost/python_web_db"
)

Base = declarative_base()

class User(Base):

    __tablename__ = "orm_users"

    id = Column(Integer, primary_key=True, autoincrement=True)

    name = Column(String(100))

    email = Column(String(100))


Base.metadata.create_all(engine)

Session = sessionmaker(bind=engine)

session = Session()

user = User(
    name="Rahul",
    email="rahul@gmail.com"
)

session.add(user)

session.commit()

print("User Added Successfully!")

session.close()
