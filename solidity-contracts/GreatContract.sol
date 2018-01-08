pragma solidity ^0.4.18;

contract GreatContract {
    address contractOwner;
    uint256 tokenPrice;
    uint256 public numberOfAllTokens;
    uint256 public numberOfAvailableTokens;
    uint256 public numberOfSoldTokens;
    mapping(address => uint256) public purchasers;

    function GreatContract() public {
        contractOwner = msg.sender;
        tokenPrice = 0.79 ether;
        numberOfAllTokens = 12;
        numberOfAvailableTokens = numberOfAllTokens;
        numberOfSoldTokens = 0;
    }

    modifier OnlyContractOwner{
        require(msg.sender == contractOwner);
        _;
    }

    function getContractOwner() public constant returns (address) {
        return (contractOwner);
    }

    function setTokenPrice(uint256 value) public OnlyContractOwner {
        tokenPrice = value;
    }

    function getTokenPrice() public constant returns (uint256) {
        return (tokenPrice);
    }

    function setNumberOfAllTokens(uint256 value) public OnlyContractOwner {
        numberOfAllTokens = value;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    function() public payable {
        uint256 amount = msg.value / tokenPrice;
        if (amount > numberOfAvailableTokens) {
            throw;
        } else {
            purchasers[msg.sender] += amount;
            numberOfSoldTokens += amount;
            numberOfAvailableTokens -= amount;
        }
    }
}